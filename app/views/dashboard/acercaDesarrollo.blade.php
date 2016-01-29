

@extends('templates/misionVisionTemplate')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3 class="page-header">Acerca del desarrollo</h3>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-11" style="margin-left:20px;">
            <p style="text-align:justify;">El desarrollo de la plataforma informática se encuentra en el marco 
                de la subvención por parte de Concytec al proyecto 209 – Fincyt – Desarrollo de una plataforma 
                Informática avanzada de gestión de tecnología en salud en establecimientos de salud peruanos. 
                Este proyecto ha sido desarrollado en dos etapas:</p>
            <br></br>
            <p style="text-align:justify;font-weight:bold;">Primera etapa:</p>
            <p style="text-align:justify;">Se realizó un levantamiento de información en tres hospitales y se 
                elaboró un mapa de procesos preliminar, para este mapa de procesos se realizó un software que 
                permitió probar la información levantada. Los participantes en la primera etapa fueron:</p>
            <ul type = disk >
                <li>Luis Alberto Vilcahuamán Cajacuri (Investigador principal)
                <li>Mauricio Francisco Córdova Torres ( Asistente de investigación)
                <li>Kelly Carol Vera Chacón (Investigadora)
                <li>María del Carmen Del Águia Gracey (Investigadora)
                <li>Eduardo Fernando Toledo Ponce (Investigador)
                <li>Ricardo Mauricio Talla Pinedo (Tesista)
                <li>Daniel Arturo Bernal Lovera (Tesista)
                <li>Kevin Lee Cam Espichán (Tesista)
            </ul>
            <br></br>
            <p style="text-align:justify;font-weight:bold;">Segunda etapa:</p>
            <p style="text-align:justify;">Se realizó la corrección del mapa de procesos, levantamiento de información 
                y re-elaboración de la plataforma informática. En esta etapa se realizó la validación de procesos y 
                software necesario. Los participantes en la segunda etapa fueron:</p>
            <ul type = disk >
                <li>Luis Alberto Vilcahuamán Cajacuri (Investigador principal)
                <li>Mauricio Francisco Córdova Torres ( Asistente de investigación)
                <li>Marcia Nathaly Carpio Diaz (Asistente de investigación)
                <li>Jenifer Katiusca Kalafatovich Espinoza (Asistente de investigación)
                <li>Kei Alonso Takayama Nakasato (Tesista)
                <li>Luis Miguel Miranda Dulanto (Tesista)
                <li>Gustavo Coronado Altamirano (Asistente de investigación)
                <li>Eduardo Antonio Merino Tejada (Asistente de investigación)
                <li>Miguel Ángel Quiroz Coral (Asistente de investigación)
            </ul>
        </div>
    </div>   
    <div class="row">
        <div class="form-group col-md-2">
            <a class="btn btn-default btn-block" href="{{URL::to('/dashboard')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>                
        </div>
    </div>  
@stop        