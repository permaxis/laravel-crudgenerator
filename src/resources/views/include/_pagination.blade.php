<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        @if ($paginator->getPrevUrl())
        <li class="page-item">
            <a class="page-link"  aria-label="Previous" href="{{ $paginator->getPrevUrl() }}" tabindex="-1">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        @endif
        @foreach ($paginator->getPages() as $page)
            @if ($page['url'])
                <li class="page-item{{ (($page['isCurrent'])? ' active' : '')  }}"><a class="page-link" href="{{  $page['url'] }}">{{  $page['num'] }} </a></li>
            @else
                <li class="page-item disabled">{{ $page['num'] }}</li>
            @endif
        @endforeach
        @if ($paginator->getNextUrl())
            <li class="page-item">
                <a class="page-link" aria-label="Next" href="{{ $paginator->getNextUrl()  }} ">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        @endif
    </ul>
</nav>