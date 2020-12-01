@extends('principal')
@section('contenido')
{{-- dashboard --}}
    <template v-if="menu==0">
        <pantalla-inicio></pantalla-inicio>
    </template>
{{-- Cartera --}}
    <template v-if="menu==1">
        <factura></factura>
    </template>
    <template v-if="menu==2">
        <contrato></contrato>
    </template>
    <template v-if="menu==3">
        <financiar></financiar>
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
    <template v-if="menu==17">
        <tasa-cambio></tasa-cambio>
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
        <reportes></reportes>
    </template>
    <template v-if="menu==14">
        <ventas></ventas>
    </template>
    <template v-if="menu==15">
        <roles-permisos></roles-permisos>
    </template>
    <template v-if="menu==16">
        <estado-cuenta></estado-cuenta>
    </template>
@endsection