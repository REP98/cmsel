@if(app('request')->input('modal'))
@include('vendor.laravel-filemanager.modal')
@else
@include('vendor.laravel-filemanager.full')
@endif
