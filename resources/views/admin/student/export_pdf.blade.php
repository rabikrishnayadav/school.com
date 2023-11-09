<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student List</title>
</head>
<body>

<div class="card-body p-0" style="overflow: auto;">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Profile</th>
        <th>Student Name</th>
        <th>Email</th>
        <th>Class</th>
        <th>Gender</th>
        <th>Mobile Number</th>
        <th>D.O.B</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $value)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            @if(!empty($value->getProfileDirect()))
            <img src="{{ $value->getProfileDirect() }}" style="width:50px; height:50px; border-radius: 50px;">
            @endif
          </td>
          <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
          <td>{{ $value->email }}</td>
          <td>{{ $value->class_name }}</td>
          <td>{{ $value->gender }}</td>
          <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
          <td style="min-width: 100px;">
            @if(!empty($value->date_of_birth))
            {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>

</body>
</html>


