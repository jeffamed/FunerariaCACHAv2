@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        {{-- <example-component></example-component> --}}
        <h3 class="pt-5">Menu 0</h3>
    </template>
    <template v-if="menu==1">
        <h3 class="pt-5">Menu 1</h3>
    </template>
    <template v-if="menu==2">
        <h3 class="pt-5">Menu 2</h3>
    </template>
    <template v-if="menu==3">
        <h3 class="pt-5">Menu 3</h3>
    </template>
    <template v-if="menu==4">
        <departamento></departamento>
    </template>
    <template v-if="menu==5">
        <h3 class="pt-5">Menu 5</h3>
    </template>
    <template v-if="menu==6">
        <h3 class="pt-5">Menu 6</h3>
    </template>   
    <template v-if="menu==7">
        <h3 class="pt-5">Menu 7</h3>
    </template>
    <template v-if="menu==8">
        <h3 class="pt-5">Menu 8</h3>
    </template>
    <template v-if="menu==9">
        <h3 class="pt-5">Menu 9</h3>
    </template>
    <template v-if="menu==10">
        <h3 class="pt-5">Menu 10</h3>
    </template>
    <template v-if="menu==11">
        <h3 class="pt-5">Menu 11</h3>
    </template>
@endsection