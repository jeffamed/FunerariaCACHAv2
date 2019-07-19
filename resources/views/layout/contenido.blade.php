@extends('principal')
@section('contenido')
{{-- dashboard --}}
    <template v-if="menu==0">
        {{-- <example-component></example-component> --}}
        <h3 class="pt-5">Menu 0</h3>
    </template>
{{-- Cartera --}}
    <template v-if="menu==1">
        <factura></factura>
    </template>
    <template v-if="menu==2">
        <contrato></contrato>
    </template>
    <template v-if="menu==3">
        <h3 class="pt-5">Menu 3</h3>
    </template>
{{-- Catalogo --}}
    <template v-if="menu==4">
        <cliente></cliente>    
    </template>
    <template v-if="menu==5">
        <servicio></servicio>
    </template>
    <template v-if="menu==6">
        <proyecto></proyecto>
    </template>   
{{-- ubicacion --}}
    <template v-if="menu==7">
        <barrio></barrio>
    </template>
    <template v-if="menu==8">
        <zona></zona>
    </template>
    <template v-if="menu==9">
        <departamento></departamento>
    </template>
    <template v-if="menu==10">
        <municipio></municipio>
    </template>
{{-- usuario --}}
    <template v-if="menu==11">
        <empleado></empleado>
    </template>
    <template v-if="menu==12">
        <acceso></acceso>
    </template>
{{-- ayuda --}}
    <template v-if="menu==13">
        <h3>menu 13</h3>
    </template>
@endsection