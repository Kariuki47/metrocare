@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('We are very sorry for inconvenience. Too Many Requests, try again later.'))
