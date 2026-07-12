<div class="row mb-3 align-items-end justify-content-end border rounded-4 py-2">
    <div class="col-12"><span class="badge rounded-pill text-bg-dark">Filter & search</span>
    <hr/>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control-sm border" placeholder="Search task" id="search_todos" value={{$search}}>
    </div>
    <div class="col-md-4">
      <select class="form-select-sm form-control-sm" aria-label="All" id="filter_todos">
        @foreach (['all'=> 'Filter by Status', '0 '=> 'Ongoing', '1' => 'Completed'] as $val => $opt)
        <option {{ $status == $val ? 'selected' : ''}} value={{ $val }}>{{ $opt }}</option>    
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <button class="btn btn-sm btn-primary py-1" id="apply_filters">apply</button>
    </div>
  </div>
