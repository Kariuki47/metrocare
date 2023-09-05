@extends('errors::minimal')

@section('title', __('Method not allowed'))
@section('code', '405')
@section('message', __($exception->getMessage() ?: 'We are very sorry for inconvenience. Contact support.'))
