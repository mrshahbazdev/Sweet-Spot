@extends('layouts.app')

@section('content')
    <livewire:customer-detail :customerId="$id" />
@endsection