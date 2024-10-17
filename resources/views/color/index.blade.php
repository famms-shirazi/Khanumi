@extends('layouts.app')
@section('title','colors')
@section('app')
<div class="card">
    <div class="card-header">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="filter[unique_id]" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
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
    </div>
    <div class="card-footer"></div>
</div>
@endsection
