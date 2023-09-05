@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'We are very sorry for inconvenience. This page is forbidden. Contact support.'))
