@isset($pageConfigs)
  {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
  lang="@if (session()->has('locale')){{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }}@endif" data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
  @if ($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description"
    content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords"
    content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">
  <title>@yield('title')</title>
  <link rel="apple-touch-icon" href="{{ asset('images/ico/favicon-32x32.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 90vh;
      display: flex;
      flex-direction: column;
    }
    .navbar {
      background-color: #333;
      overflow: hidden;
      margin-bottom: 20px;
    }
    .navbar a {
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
    }
    .navbar a:hover {
      background-color: #ddd;
      color: black;
    }

    .chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      margin: 0 auto;
      max-width: 400px;
      width: 100%;
      background-color: #f9f9f9;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .chat-header {
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      text-align: center;
    }
    .chat-messages {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      display: flex;
      flex-direction: column-reverse;
    }
    .chat-message {
      background-color: #e5e5ea;
      padding: 8px;
      border-radius: 8px;
      margin-bottom: 10px;
      display: flex;
      flex-direction: column;
    }
    .chat-message.sent {
      background-color: #007bff;
      color: #fff;
      align-self: flex-end;
    }
    .chat-message.received {
      background-color: #f4f4f4;
      color: #333;
      align-self: flex-start;
    }
    .chat-message .message-meta {
      font-size: 0.8em;
      color: #555;
      text-align: right;
      margin-top: 5px;
    }
    .chat-input {
      display: flex;
      align-items: center;
      background-color: #f9f9f9;
      border-top: 1px solid #ddd;
    }
    .chat-input input[type="text"] {
      flex: 1;
      padding: 10px;
      border: none;
      outline: none;
    }
    .chat-input button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 0 8px 8px 0;
    }
  </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

  {{-- @extends('clientLayouts.horizontalLayoutMaster' ) --}}
  <div class="content-body">

    {{-- Include Page Content --}}
    @yield('content')

  </div>
