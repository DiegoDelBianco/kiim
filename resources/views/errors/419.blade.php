@extends('errors::minimal')

@section('title', __('Página expirada'))
@section('code', '419')
@section('message', __('Ops, o token de segurança da página expirou. Por favor, volte a página aterior, atualize e tente novamente.'))
