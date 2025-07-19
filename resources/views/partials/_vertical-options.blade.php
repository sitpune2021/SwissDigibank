<div class="relative">
    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
    <ul class="horiz-option popover-content">
        @isset($viewRoute)
            <li>
                <a href="{{ route($viewRoute, $id) }}" class="single-option">
                    View
                </a>
            </li>
        @endisset
        @isset($editRoute)
            <li>
                <a href="{{ route($editRoute, $id) }}" class="single-option">
                    Edit
                </a>
            </li>
        @endisset
        <!-- <li>
      <span
        class="single-option">
        Delete
      </span>
    </li> -->
    </ul>
</div>
