<div>
  @include('components.todos_filter_search', [$status, $search]) 
<table class="table">
  <thead class="table-light">
    <tr>
      <th scope="col">ID</th>
      <th scope="col" style="width: 60%;">Task Title</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    @if (!empty($tasks))
    @foreach ($tasks as $task)
        @include('components.todos_table_row', compact('task'))
    @endforeach
    @else
    No Tasks yet
    @endif
  </tbody>
</table>
  <div class="col-md-12">
      <div id="pagination_links" class="pagination-sm">
        {{ $tasks->links('pagination::bootstrap-5') }}
      </div>
    </div>
    <input type='hidden' id="current_page" value={{ $current_page }}>
    <div class="col-md-12 mt-2">
        @include('components.new_todo_form')
    </div>
</div>
