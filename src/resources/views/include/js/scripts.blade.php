<script>
$( document ).ready(function() {

    //select/unselect items in view list
    $(document).off('click','#selectAllItems');
    $(document).on('click','#selectAllItems',function(){
        if ($(this).is(':checked'))
        {
            $('input[name="selectItem"]').prop('checked', true);
        }
        else
        {
            $('input[name="selectItem"]').prop('checked', false);
        }
    });

    function createModal($options)
    {
        $options = $options || {};
        $modal = '<div class="modal fade" role="dialog">' +
                '    <div class="modal-dialog modal-lg">' +
                '        <!-- Modal content-->' +
                '        <div class="modal-content">' +
                '            <div class="modal-header">' +
                '                <button type="button" class="close" data-dismiss="modal">&times;</button>' +
                '                <h3 class="modal-title"></h3>' +
                '            </div>' +
                '            <div class="modal-body" id="modal-body-list-items"></div>' +
                '            <div class="modal-footer"></div>' +
                '        </div>' +
                '     </div>' +
                '</div>';
        $modal = $($modal);

        if ($options['id'])
        {
            $modal.attr('id',$options['id'])
        }
        if ($options['title'])
        {
            $modal.find('.modal-title').text($options['title']);
        }

        return $modal;
    }


    //delete selected items in view list
    jQuery.fn.extend({
        deleteSelectedItems: function($params) {
            $params = $params || {};

            $selector = $params['selector'] || '#' + this.attr('id');
            $url = $params['url'];
            $urlRedirect = $params['urlRedirect'];


            //$(document).on('click','#delete-selected-items'.on('click',function(){
            $(document).on('click', $selector ,function(){
                selectedItems = $('input[name="selectItem"]:checked');
                obj = [];
                selectedItems.each(function(index,item){
                    itemId = $(item).closest('tr[data-id]').data('id');
                    if (itemId)
                    {
                        obj.push({
                            'id' : itemId
                        });
                    }
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                $.ajax({
                    url: $url,
                    type: 'DELETE',
                    dataType: 'json',
                    data : JSON.stringify(obj),
                    contentType: 'application/json',
                    success: function ($result) {
                        document.location.href= $urlRedirect;
                    },
                });

            });
        }
    });

    $(document).on('click','.close', function(e) {
        modal = $(this).closest('.modal');
        modal.find('.modal-body').html('');
        modal.modal('hide')
    });

});
</script>
<script>
    function inlineFieldUpdate($options)
    {
        var $selector = $options['selector'];

        //json contains corresponding element form by field in entity
        var $fields = $options['fields'];

        //Remote Url for Update Entity
        var $remoteUrl = $options['remoteUrl'];

        var $token = $options['_token'];


        //correponding element form appears
        //state pass read to write
        // Get the input field
        /*var input = document.getElementById("myInput");

         // Execute a function when the user releases a key on the keyboard
         input.addEventListener("keyup", function(event) {
         // Cancel the default action, if needed
         event.preventDefault();
         // Number 13 is the "Enter" key on the keyboard
         if (event.keyCode === 13) {
         // Trigger the button element with a click
         document.getElementsByClassName("confirm-update-field").click();
         }
         });*/

        //Event on click Element Form is visible
        $($selector).on('click',function(event){
            event.preventDefault();

            $inlineUpdateField = $(this);
            //prevent trigger click from child click (cancel or update)
            if(event.target != event.currentTarget) {
                return;
            }

            //reset all form elments
            resetAllFormElements();

            //check if form elment switched already exists
            if ($inlineUpdateField.data('fieldstate') == 'write')
            {
                return;
            }

            //switch to form element
            $field = $fields[$inlineUpdateField.data('field')];
            console.log($field);
            if (typeof $field === 'undefined' )
            {
                return ;
            }
            $fieldValue = $inlineUpdateField.attr('data-fieldvalue');
            $fieldUrlUpdate = $inlineUpdateField.attr('data-urlupdate');
            if (typeof $field['default'] !== undefined && $fieldValue == '')
            {
                $inlineUpdateField.attr('data-fieldvalue',$field['default'])
                $inlineUpdateField.attr('data-updatedfieldvalue',$field['default'])
            }
            $fieldValue = $inlineUpdateField.data('fieldvalue');
            //check if json exists for that field
            if (!$field)
            {
                return;
            }

            $form = $('<form method="POST" id="inline-update-field">' +
                    '<input name="_method" type="hidden" value="PUT">' +
                    '<input name="_token" type="hidden" value="' + $token + '">');
            $form.attr('action', $inlineUpdateField.data('urlupdate'));
            if ($field['type'] == 'select')
            {
                $select = createSelectFormElement($field,$fieldValue,$inlineUpdateField);
                $form.append($select);
                $inlineUpdateField.data('fieldstate','write');
            }

            if ($field['type'] == 'text')
            {
                $text = createTextFormElement($field, $fieldValue , $inlineUpdateField);
                $form.append($text);
                $inlineUpdateField.data('fieldstate','write');
            }


            /*$table = $('<table border="0" style="border:none"/>');
            $table.append('<tr>' +
                    '<td class="cancel-update-field" style="border:none">' +
                    '<button type="button" name="cancel" value="annuler"><i class="glyphicon glyphicon-log-out"></button>' +
                    '</td>' +
                    '<td class="confirm-update-field" style="border:none">' +
                    '<button type="submit" name="valider" value="valider"><i class="glyphicon glyphicon-floppy-save"></button>' +
                    '</td>' +
                    '</tr>')*/
            $table = $('<div class="row"/>');
            $table.append('' +
                    '<div class="col-sm-offset-3 col-sm-2 cancel-update-field" style="border:none">' +
                    '<button type="button" name="cancel" value="annuler"><i class="glyphicon glyphicon-log-out"></i></button>' +
                    '</div>' +
                    '<div class="col-sm-2 confirm-update-field" style="border:none">' +
                    '<button type="submit" name="valider" value="valider"><i class="glyphicon glyphicon-floppy-save"></i></button>' +
                    '</div>' +
                    '')


            $form.append($table);

            $inlineUpdateField.html($form);

        });

        //reset all element form
        function resetAllFormElements()
        {
            $($selector).each(function(){
                if ($(this).data('fieldstate') == 'write') {
                    $(this).html($(this).data('fieldformatedvalue'));
                    $(this).data('fieldstate', 'read');
                }
            });
        }

        //cancel show element form
        $(document).delegate('.cancel-update-field', 'click', function(e){
            $inlineUpdateField = $(this).closest($selector);
            $inlineUpdateField.html($inlineUpdateField.data('fieldformatedvalue'));
            $inlineUpdateField.data('fieldstate','read');
            e.stopPropagation();
        });

        //confirm update value of Nd_lead field with element form
        //value sent to database
        $(document).delegate('.confirm-update-field', 'click', function(){
            $inlineUpdateField = $(this).closest($selector);
            $fieldValue = $inlineUpdateField.data('fieldvalue');
            $updatedFieldValue = $inlineUpdateField.data('updatedfieldvalue');
            //if ($updatedFieldValue!== '' && $fieldValue!=$updatedFieldValue)
            //if ($updatedFieldValue!== '' && $fieldValue!== '')
            //{
                //save data to database
                saveUpdatedValue($inlineUpdateField);
            //}

        });

        //create form select whith params from data attribute
        function createSelectFormElement($params, $fieldValue, $inlineUpdateField)
        {
            console.log($params['name']);
            $select = $('<select class="form-control"/>').attr('name',$params['name']);
            $option = $('<option/>').val('').text('Selectionner une valeur');
            $select.append($option);
            $.each($params['values'], function($key, $value) {
                $option = $('<option/>').val($key).text($value);
                if ($fieldValue == $key)
                {
                    $option.attr('selected','selected');
                    console.log($option);
                }
                $select.append($option);
            });


            $inlineUpdateField.attr('data-field',$fieldValue);
            $inlineUpdateField.attr('data-updatedfieldvalue',$fieldValue);

            $select.on('change',function() {
                $updatedFieldValue = $(this).find('option:selected').val();
                $inlineUpdateField.data('fieldvalue',$updatedFieldValue);
                $inlineUpdateField.data('updatedfieldvalue',$updatedFieldValue);
                $inlineUpdateField.attr('data-updatedfieldvalue',$updatedFieldValue);
                $inlineUpdateField.attr('data-fieldvalue',$updatedFieldValue);
            })
            return $('<div class="form-group"/>').html($select);
        }

        //create form text whith params from data attribute
        function createTextFormElement($params, $fieldValue, $inlineUpdateField)
        {
            $input = $('<input type="text" class="form-control"/>').attr('name',$params['name']).attr('style','width:100%');
            $input.val($fieldValue);
            $inlineUpdateField.data('updatedfieldvalue',$fieldValue);
            $input.on('change',function() {
                $updatedFieldValue = $(this).val();
                $inlineUpdateField.data('fieldvalue',$updatedFieldValue);
                $inlineUpdateField.data('updatedfieldvalue',$updatedFieldValue);
                $inlineUpdateField.attr('data-updatedfieldvalue',$updatedFieldValue);
                $inlineUpdateField.attr('data-fieldvalue',$updatedFieldValue);
            })
            return $('<div class="form-group"/>').html($input);
        }

        //save updated value to database
        /*function saveUpdatedValue($inlineUpdateField)
        {
            var myObject = new Object();
            myObject.entityid = $inlineUpdateField.data('fieldid');
            myObject.fieldname = $inlineUpdateField.data('field');
            myObject.fieldvalue = $inlineUpdateField.data('updatedfieldvalue');
            myJson = JSON.stringify(myObject);
            $.ajax({
                type: "POST",
                url: $remoteUrl,
                data: myObject,
                success: function(result,textStatus,jqXHR) {
                    if (result['status'] == 'success')
                    {
                        switchToReadElement($inlineUpdateField, result['data'])
                    }

                },
                dataType: 'json'
            });
        }*/

        function saveUpdatedValue($inlineUpdateField)
        {
            $inlineUpdateField.find('form').ajaxSubmit({
                success: function(result, statusText, xhr, $form) {
                    console.log(result);
                    if (result['status'] == 'success')
                    {
                        //console.log(result);
                        switchToReadElement($inlineUpdateField, result['data'])
                    }
                },
            });
        }


        //switch to read element with updated result
        function switchToReadElement($inlineUpdateField, result)
        {
            $inlineUpdateField.html(result['fieldformatedvalue']);
            $inlineUpdateField.data('fieldvalue',result['fieldvalue']);
            $inlineUpdateField.data('fieldformatedvalue',result['fieldformatedvalue']);
            $inlineUpdateField.attr('data-fieldvalue',result['fieldvalue']);
            $inlineUpdateField.attr('data-fieldformatedvalue',result['fieldformatedvalue']);
            $inlineUpdateField.data('fieldstate','read');
            console.log(result);
        }
    };
</script>