@extends('layouts.app')
@section('title','colors')
@section('app')
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">unique_id</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($colors as $color)
      <tr>
        <th scope="row">{{$color->id}}</th>
        <td>{{$color->unique_id}}</td>
        <td>{{$color->created_at}}</td>
        <td>{{$color->updated_at}}</td>
      </tr>
      @empty
        <tr>
            <td colspan="4">موردی برای نمایش وجود ندارد</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  {{$colors->links()}}
@endsection
