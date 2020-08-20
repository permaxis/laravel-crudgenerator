<?php

namespace Permaxis\CrudGenerator\App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Permaxis\Core\App\Services\Paginator\Paginator;
use Permaxis\CrudGenerator\App\Entities\EntityModel as Entity;
use Symfony\Component\HttpFoundation\JsonResponse;

class EntityModelsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only([
            'sort_by',
            'sort_dir',
            'id',
   /*bc*/   'name', /*ec*/
            'layout',
            'page'
        ]);

        //process  sorting
        list($sortBy, $sortDir, $sorting ) = $this->processSorting($request, 'id','desc', [
            'id',
   /*bc*/   'name', /*ec*/
            'created_at',
            'updated_at',
            'enabled'
        ]);

        $page = (isset($input['page']) && !empty($input['page']))? (int) $input['page'] : 1;

        $qb = Entity::query();

        $this->processSearch($request, $qb);


        $pagination = $qb->orderBy($sortBy, $sortDir)->paginate(5,'*','page',$page);
        $total = $pagination->total();

        $entities = $qb->get();

         //process  pagination
        $paginator = $this->processPagination($request, [
            'total' => $total,
            'per_page' => $pagination->perPage(),
            'current_page' => $pagination->currentPage()
        ], $this->routeNamePrefix().'.index');

        return View::make($this->viewsDir().'entities.index', compact(
            'entities',
            'total',
            'sortBy',
            'sortDir',
            'paginator',
            'input',
            'sorting'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewsDir().'entities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entity = new Entity();

        $request = $this->handleRequest($request);

        $params = $this->handleForm($request, $entity);

        $result = $entity->save();

        if ($result)
        {
            Session::flash('createAction','success');

            if (isset($params['createAndAddAnother']))
            {
                return redirect(route($this->routeNamePrefix().'.create'));
            }
            return redirect(route($this->routeNamePrefix().'.index'));
        }
        else
        {
            Session::flash('createAction','failed');
            return view($this->viewsDir().'entities.create',compact('entity'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Entity::query()->find($id);

        return view($this->viewsDir().'entities.show',compact('entity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = Entity::query()->find($id);
        return view($this->viewsDir().'entities.edit', compact('entity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entity = Entity::query()->find($id);

        $request= $this->handleRequest($request);

        $params = $this->handleForm($request, $entity);

        $result = $entity->save();

        if ($result)
        {
            if ($request->isXmlHttpRequest())
            {
                return array(
                    'status' => 'success',
                    'data' => $this->getResultsFromInlineUpdateField(['entity' => $entity, 'input' => $params]),
                );
            }

            Session::flash('updateAction','success');
            return redirect()->route($this->routeNamePrefix().'.edit',['id' => $entity->id])->with('updateAction','success');
        }
        else
        {
            if ($request->isXmlHttpRequest())
            {
                return array(
                    'status' => 'error',
                    'message' => $entity->errors()->all(),
                    'params' => $this->getResultsFromInlineUpdateField(['entity' => $entity, 'input' => $params]),
                );
            }

            Session::flash('updateAction','failed');
            return view($this->viewsDir().'entities.edit',compact('entity'));
        }

        //return $entity;

        //return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $entity = Entity::query()->find($id);

        return view($this->viewsDir().'entities.delete',compact('entity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entity = Entity::query()->find($id);

        $entity->delete();

        Session ::flash('deleteAction','success');

        return redirect(route($this->routeNamePrefix().'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  json string containing  $ids
     * @return \Illuminate\Http\Response
     */
    public function destroyEntities(Request $request)
    {
        $entities= $request->all();

        $result = array();
        try {
            foreach ($entities as $entity)
            {
                $entity = Entity::query()->find($entity['id']);
                $entity->delete();
            }
            $result = array(
                'status' => 'success',
                'message' => ''
            );
            Session ::flash('deleteAction','success');
        }
        catch(\Exception $e)
        {
            $result = array(
                'status' => 'failed',
                'message' => ''
            );
            Session ::flash('deleteAction','failed');
        }

        return $result;
    }


    public function handleForm(Request $request, &$entity)
    {

        $input = $request->all();

        $fillInput = $input;

        $entity->fill($fillInput);

        return $input;

    }

    /**
     * @param Request $request
     */
    public function processSearch(Request $request, &$qb)
    {
        $request = $this->handleRequest($request);

        $input = $request->all();

        if (isset($input['id']) && !empty($input['id']))
        {

            $qb->where('id','like', '%'.$input['id'].'%');
        }

        /*bc*/if (isset($input['name']) && !empty($input['name']))
        {
            $qb->where('name','like','%'.$input['name'].'%');
        }/*ec*/

        return $this;
    }


    public function getResultsFromInlineUpdateField($results)
    {
        //return $results;
        if (!isset($results['input']))
        {
            return [];
        }
        $data = [];
        foreach ($results['input'] as $fieldName => $fieldValue)
        {
            switch ($fieldName)
            {
                case('name'):
                    $data['fieldformatedvalue'] = $results['entity']->name;
                    $data['fieldvalue'] = $results['entity']->name;
                    break;
                case('enabled'):
                    $data['fieldformatedvalue'] = ($results['entity']->enabled)? 'Yes' : 'No';
                    $data['fieldvalue'] = $results['entity']->enabled;
                    break;
            }

        }
        return $data;
    }


    public function handleRequest(Request $request)
    {

        $input = $request->all();

        array_walk_recursive($input, function(&$value) {
            $value = trim($value);
        });

        $request->replace($input);

        return $request;
    }

    //Defautl sorting
    public function processSorting(Request $request , $default_sort_by = 'id' , $default_sort_dir = 'asc', $keys = [])
    {
        $input = $request->all();

        $sortBy = (isset($input['sort_by']) && !empty($input['sort_by']) )? $input['sort_by'] : $default_sort_by ;
        $sortDir = (isset($input['sort_dir']) && !empty($input['sort_dir']) )? $input['sort_dir'] : $default_sort_dir ;

        $sorting = array();

        $input_sorting = $input;
        unset($input_sorting['page']);

        foreach ($keys as $key)
        {
            $sorting[$key] = array_merge($input_sorting, ['sort_by' => $key,'sort_dir' =>  (isset($sortBy) && $sortBy == $key && isset($sortDir) && $sortDir == 'asc') ? 'desc' : 'asc']);
        }

        return array($sortBy, $sortDir,$sorting );

    }


    public function processPagination(Request $request, $pagination , $rout_name)
    {
        $input = $request->all();

        $paginator = new Paginator(
            $pagination['total'],
            $pagination['per_page'],
            $pagination['current_page'],
            route($rout_name, array_merge($input, array('page' => 'num')))
        );

        return $paginator;

    }

    public function routeNamePrefix()
    {
        return 'crudgenerator.entities';
    }

    public function viewsDir()
    {
        return 'crudgenerator::';
    }

}
