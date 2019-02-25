<template>
    <div class="container-fluid">
        <div class="card-panel">
            <div class="card-header">
                <h5>Dashboard</h5>
                <!-- <button class="btn" @click="enviarTwilio()">Enviar</button> -->
            </div>
            <div class="row" style="margin-top:5px">
                <div class="col s12 m3">
                    <v-card color="teal" class="white--text">
                        <v-layout row align-center>
                            <v-flex md8 xs12>
                                <v-card-title primary-title>
                                    <div>
                                        <div class="headline">
                                            <span v-text="numeroContactos" class="white-text numero-card-dashboard"></span>
                                        </div>
                                        <div>
                                            <span class="white-text texto-card-dashboard">CONTACTOS REGISTRADOS</span>
                                        </div>
                                    </div>
                                </v-card-title>
                            </v-flex>
                            <v-flex md4 xs-12 hidden-sm-only>
                                <span class="dot">
                                    <v-icon color="teal" size="50">fas fa-comments</v-icon>
                                </span>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </div>
                <div class="col s12 m3">
                    <v-card color="teal" class="white--text">
                        <v-layout row align-center>
                            <v-flex md8 xs12>
                                <v-card-title primary-title>
                                    <div>
                                        <div class="headline">
                                            <span v-text="cantidadCampanias" class="white-text numero-card-dashboard"></span>
                                        </div>
                                        <div>
                                            <span class="white-text texto-card-dashboard">MENSAJES ENVIADOS</span>
                                        </div>
                                    </div>
                                </v-card-title>
                            </v-flex>
                            <v-flex md4 xs-12 hidden-sm-only>
                                <span class="dot" style="padding: 18px;">
                                    <v-icon color="teal" size="50">far fa-calendar-check</v-icon>
                                </span>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </div>
                <div class="col s12 m3">
                    <v-card color="teal" class="white--text">
                        <v-layout row align-center>
                            <v-flex md8 xs12>
                                <v-card-title primary-title>
                                    <div>
                                        <div class="headline">
                                            <span class="white-text numero-card-dashboard">0</span>
                                        </div>
                                        <div>
                                            <span class="white-text texto-card-dashboard">PRÓXIMAMENTE</span>
                                        </div>
                                    </div>
                                </v-card-title>
                            </v-flex>
                            <v-flex md4 xs-12 hidden-sm-only>
                                <span class="dot">
                                    <v-icon color="teal" size="50">fas fa-users</v-icon>
                                </span>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </div>
                <div class="col s12 m3">
                    <v-card color="teal" class="white--text">
                        <v-layout row align-center>
                            <v-flex md8 xs12>
                                <v-card-title primary-title>
                                    <div>
                                        <div class="headline">
                                            <span class="white-text numero-card-dashboard">0</span>
                                        </div>
                                        <div>
                                            <span class="white-text texto-card-dashboard">PRÓXIMAMENTE</span>
                                        </div>
                                    </div>
                                </v-card-title>
                            </v-flex>
                            <v-flex md4 xs-12 hidden-sm-only>
                                <span class="dot">
                                    <v-icon color="teal" size="50">fas fa-users</v-icon>
                                </span>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </div>

            </div>

            <!-- <template>
                <v-card flat>
                    <v-card-title>
                        <h5>Lista de respuestas</h5>
                        <v-spacer></v-spacer>
                        <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Buscar"
                        single-line
                        hide-details
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="todasRespuestas"
                        :search="search"
                    >
                        <template slot="items" slot-scope="props">
                            <td class="text-xs-center">{{ props.item.contacto }}</td>
                            <td class="text-xs-center">{{ props.item.celular }}</td>
                            <td class="text-xs-center">{{ props.item.respuesta }}</td>
                            <td class="text-xs-center">
                                <v-btn flat icon color="teal" class="modal-trigger" @click="enviarMensaje(props.item)"><v-icon>mail</v-icon></v-btn>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                        No encontramos "{{ search }}" que buscabas.
                        </v-alert>
                    </v-data-table>
                </v-card>
            </template> -->

        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    import moment from 'moment'
    import colors from 'vuetify/es5/util/colors'

    export default {
        data (){
            return {
                mensajesDisponibles:'',
                cantidadCampanias : '',
                numeroContactos: '',
                search : '',
                todasRespuestas : [],
                headers: [
                    { text: 'Contacto', align: 'center', value: 'contacto' },
                    { text: 'Celular', align: 'center', value: 'celular' },
                    { text: 'Respuesta', align: 'center', value: 'respuesta' },
                    { text: 'Opciones', align: 'center', value: 'opciones' }
                ],
            }
        },
        created : function(){
            this.contarDisponibles();
            this.contarCampanias();
            this.listarRespuesta();
            this.contarContactos();
        },
        methods:{
            enviarTwilio:function(){
                var url = "/administrador/enviarTwilio";
                axios.get(url).then(response => {
                    console.log(response.data);
                });
            },
            contarDisponibles:function() {
                let me = this;
                var url = '/administrador/contarMensajerias';
                axios.get(url).then(response => {
                    me.mensajesDisponibles = response.data;
                });
            },

            contarContactos : function () {
                let me = this;
                var url = '/contactos/contartodos';
                axios.get(url).then(response => {
                    me.numeroContactos = response.data;
                });
            },

            contarCampanias:function() {
                let me = this;
                var url = '/administrador/contarCampanias';
                axios.get(url).then(response => {
                    me.cantidadCampanias = response.data;
                });
            },

            listarRespuesta: function(mensajeriaId) {
                let me = this;
                var url = "/administrador/listarRespuestaByUser/";
                axios.get(url).then(response => {
                    me.todasRespuestas = response.data;
                });
            },

            enviarMensaje: async function(contacto){
                const {value: text} = await Swal({
                    input: 'textarea',
                    inputPlaceholder: 'Escribe el mensaje aquí...',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    cancelButtonColor: '#ef5350',
                    confirmButtonText: 'Enviar',
                    confirmButtonColor: 'teal',
                })

                if (text) {
                    var url = 'https://wa.me/'+contacto.celular+'?text=';
                    var mensaje= this.prepararMsj(text);
                    var url = url+mensaje;
                    window.open(url, '_blank');
                }
            },
            prepararMsj :function(mensajeSinPreparar){
            var mensajePreparado="";
            var i;
            for(i=0;i<mensajeSinPreparar.length+1;i++){
                if(mensajeSinPreparar.substring(i,i+1)==" "){
                    mensajePreparado += "%20";
                }else{
                    if(mensajeSinPreparar.substring(i,i+1)!="@"){
                        mensajePreparado += mensajeSinPreparar.substring(i,i+1);
                    }
                }
            }
            return(mensajePreparado);
            },
        }
    }
</script>
