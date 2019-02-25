@extends('plataforma.layout')
@section('content')
<template>
   <perfil_contacto :contact="{{ json_encode($contacto) }}"></perfil_contacto>
</template>
@stop