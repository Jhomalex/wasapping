<template>
  <div class="container-fluid">
    <div class="card-panel">
      <div class="card-header">
        <h5>Contacto</h5>
      </div>
      <div class="row">
        <div class="col s12 m3 grey lighten-4">
           <div class="col s12 center">
              <img :src="'/img/usuarios/boy.png'" height="150" width="150" class="circle responsive-img">
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">NOMBRE</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.nombre"></p>
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">DNI</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.dni"></p>
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">RUC</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.ruc"></p>
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">Celular</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.celular"></p>
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">CORREO</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.correo"></p>
           </div>
           <div class="col s12">
              <b><p style="font-size:12px;margin:0px;" class="grey-text">REFERENCIA</p></b>
              <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.referencia"></p>
           </div>
        </div>
        <div class="col s12 m9">
            <ul id="tabs-swipe-demo" class="tabs">
               <li class="tab col s3"><a class="active" href="#test-swipe-1">Actividad</a></li>
            </ul>
            <div>
               <span style="font-size:14px;" class="grey-text text-darken-3">Registrar</span>
               <button class="btn-small teal z-depth-0 waves-effect" @click="abrirModalActividad('crear')" style="margin-top:2px">Actividad</button>
            </div>
            <div id="test-swipe-1">
               <v-list two-line>
                  <v-list-tile v-for="actividad in todasActividades" :key="actividad.id">
                     <v-list-tile-content>
                        <v-list-tile-title v-text="actividad.descripcion"></v-list-tile-title>
                     </v-list-tile-content>
                     <v-list-tile-action>
                        <div class="font-weight-thin" 
                        v-text="convertirDateTimeAFecha(actividad.fechaHoraContactado)"></div>
                     </v-list-tile-action>
                     <v-list-tile-action>
                        <a class='dropdown-trigger btn-small btn-floating waves-effect white z-depth-0' @click="abrirModalActividad('editar', actividad)">
                           <i class="material-icons grey-text text-darken-2">edit</i>
                        </a>
                     </v-list-tile-action>
                     <v-list-tile-action>
                        <a class='dropdown-trigger btn-small btn-floating waves-effect white z-depth-0' @click="deleteActividad(actividad)">
                           <i class="material-icons grey-text text-darken-2">delete</i>
                        </a>
                     </v-list-tile-action>
                  </v-list-tile>

                  <v-divider inset></v-divider>
               </v-list>

            </div>
            
            <!--div id="test-swipe-2">Notas</div-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { moment } from "../app";
export default {
  props: ["contact"],
  data() {
    return {
      contacto: this.contact[0],
      buscar: "",
      criterio: "",
      todasActividades: []
    };
  },
  
  mounted() {
    this.listarRegistro(this.buscar, this.criterio);
  },
  
  methods: {
    listarRegistro: function(buscar, criterio) {
      let me = this;
      var url =
        "/actividad/listar?buscar=" +
        buscar +
        "&criterio=" +
        criterio +
        "&contacto=" +
        me.contacto.id;
      axios.get(url).then(response => {
        me.todasActividades = response.data;
        console.log(response.data);
      });
    },

    convertirDateTimeAHora: function(datetime) {
      return moment(datetime).format("hh:mm a");
    },
    convertirDateTimeAFecha: function(datetime) {
      return moment(datetime).format("YYYY-MM-DD");
    },

    abrirModalActividad(criterio, actividad) {
      eventBusActividad.$emit(
        "abrirModalActividad",
        criterio,
        actividad,
        this.contacto.id
      );
    },

    deleteActividad: function(actividad) {
      let me = this;
      swal({
        title: "¿Realmente deseas eliminar la actividad?",
        text: "Se borrará la actividad de manera permanente",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          axios
            .post("/actividad/delete", {
              actividadId: actividad["id"]
            })
            .then(function(response) {
              console.log(response);
              if (response.data == "Ok") {
                me.listarRegistro("", me.criterio);
                swal("La actividad ha sido borrada con éxito!", {
                  icon: "error"
                });
              } else {
                swal("No se pudo borrar la actividad");
              }
            })
            .catch(function(error) {
              console.log(error);
            });
        } else {
          swal("Usted ha cancelado la eliminación del evento");
        }
      });
    }
  }
};
</script>