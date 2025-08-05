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
     @isset($printRoute)
    <a href="{{ route($printRoute, $id) }}" target="_blank" class="single-option">
      Print
    </a>
    @endisset
    @isset($deleteRoute)
    <form action="{{ route($deleteRoute, $id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="single-option">
        Delete
      </button>
    </form>
    @endisset
  </ul>
</div>
