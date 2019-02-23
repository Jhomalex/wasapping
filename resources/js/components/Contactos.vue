<template>
    <div class="container-fluid">
        <div class="card-panel">
            <div class="card-header">
                <h5>Contactos</h5>
                <!-- <button class="btn" @click="enviarTwilio()">Enviar</button> -->
            </div>
            <template>
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
                        :items="todosContactos"
                        :search="search"
                    >
                        <template slot="items" slot-scope="props">
                            <td class="text-xs-center">{{ props.item.nombre }}</td>
                            <td class="text-xs-center">{{ props.item.celular }}</td>
                            <td class="text-xs-center">{{ props.item.dni }}</td>
                            <td class="text-xs-center">{{ props.item.ruc }}</td>
                            <td class="text-xs-center">{{ props.item.correo }}</td>
                            <td class="text-xs-center">
                                <v-btn flat icon color="teal" class="modal-trigger" @click="enviarMensaje(props.item)"><v-icon>mail</v-icon></v-btn>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                        No encontramos "{{ search }}" que buscabas.
                        </v-alert>
                    </v-data-table>
                </v-card>
            </template>
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
                search : '',
                todosContactos : [],
                headers: [
                    { text: 'Nombre', align: 'center', value: 'nombre' },
                    { text: 'Celular', align: 'center', value: 'celular' },
                    { text: 'DNI', align: 'center', value: 'dni' },
                    { text: 'RUC', align: 'center', value: 'ruc' },
                    { text: 'Correo', align: 'center', value: 'correo' },
                    { text: 'Opciones', align: 'center', value: 'opciones' }
                ],
            }
        },
        created : function(){
            this.listarRespuesta();
        },
        methods:{
            listarRespuesta: function(mensajeriaId) {
                let me = this;
                var url = "/contactos/listar/";
                axios.get(url).then(response => {
                    me.todosContactos = response.data;
                });
            },  
        }
    }
</script>
