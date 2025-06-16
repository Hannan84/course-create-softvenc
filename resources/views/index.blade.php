@extends('welcome')
@section('content')
<div class="container">
  <h2>Course List</h2>
  <div class="table-wrapper">
    <table class="course-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Course Title</th>
          <th>Category</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($courses as $index => $course)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $course->name }}</td>
          <td>{{ $course->category }}</td>
          <td>{{ $course->description }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
