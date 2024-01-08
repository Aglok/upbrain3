{{--Пагинация--}}
<div>
    <ul class="pagination">
        @if($posts->currentPage() > 1)
            <li class="page-item">
                <a class="page-link" href="{{route('posts_list')}}?page={{$posts->currentPage() - 1}}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @endif
        @foreach($arrayNumbers as $page)
            <li class="page-item {{ $posts->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{route('posts_list')}}?page={{$page}}">{{$page}}</a>
            </li>
        @endforeach

        @if($posts->currentPage() <= count($arrayNumbers))
            <li class="page-item">
                <a class="page-link" href="{{route('posts_list')}}?page={{$posts->currentPage() + 1}}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        @endif
    </ul>
</div>