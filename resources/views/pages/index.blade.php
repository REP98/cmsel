@extends('layouts.app')

@section('style')
@parent
{!! $style !!}
@endsection

@section('script')
@parent
{!! $script !!}
@endsection

@section('content')
@parent
{!! $content !!}
@endsection