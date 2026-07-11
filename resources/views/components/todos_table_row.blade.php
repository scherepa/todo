<tr>
    <th scope="row">{{$task->id}}</th>
    <td>{{ $task->title }}</td>
    <td>@include('components.todos_row_actions', compact('task'))</td>
</tr>
