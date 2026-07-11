<div>
  <div class="row mb-3 align-items-end justify-content-end border rounded-4 py-2">
    <div class="col-12"><span class="badge rounded-pill text-bg-dark">Filter & search</span>
    <hr/>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control-sm border" placeholder="Search task" id="search_todos" value={{$search}}>
    </div>
    <div class="col-md-4">
      <select class="form-select-sm form-control-sm" aria-label="All" id="filter_todos">
        <option {{$status == 'all' ? 'selected' : ''}} value="all">Filter By Status</option>
        <option value="0" {{$status == '0' ? 'selected' : ''}}>Ongoing</option>
        <option {{$status == '1' ? 'selected' : ''}} value="1">Completed</option>
      </select>
    </div>
    <div class="col-md-3">
      <button class="btn btn-sm btn-primary py-1" id="apply_filters">apply</button>
    </div>
  </div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Task Title</th>
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
