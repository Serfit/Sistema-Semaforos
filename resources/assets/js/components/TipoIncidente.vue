<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Tipo Incidente
          <button
            type="button"
            @click="abrirModal('incidente', 'registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="tipo_incidente">Tipo Incidente</option>
                  
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarIncidente(1, buscar, criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarIncidente(1, buscar, criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Opciones</th>
                <th>Tipo Incidente</th>
                
              </tr>
            </thead>
            <tbody>
              <tr v-for="incidente in arrayIncidente" :key="incidente.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('incidente', 'actualizar', incidente)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    @click="dasactivarIncidente"
                  >
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td v-text="incidente.tipo_incidente"></td>
                

                
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="
                    cambiarPagina(pagination.current_page - 1, buscar, criterio)
                  "
                  >Ant</a
                >
              </li>
              <li
                class="page-item"
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page, buscar, criterio)"
                  v-text="page"
                ></a>
              </li>

              <li
                class="page-item"
                v-if="pagination.current_page < pagination.last_page"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="
                    cambiarPagina(pagination.current_page + 1, buscar, crietrio)
                  "
                  >Sig</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{ mostrar: modal }"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button
              type="button"
              class="close"
              @click="cerrarModal()"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              action=""
              method="post"
              enctype="multipart/form-data"
              class="form-horizontal"
            >
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Tipo Incidente</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="incidente"
                    class="form-control"
                    placeholder='Tipo incidente'
                  />
                  <!-- <span class="help-block">(*) Ingrese el nombre de la persona</span>-->
                </div>
              </div>

              
              <div v-show="errorIncidente" class="form-group row div-error">
                <div class="text-center text-error" @click="cerrarModal()">
                  <div
                    v-for="error in errorMostrarMsjIncidente"
                    :key="error"
                    v-text="error"
                  ></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button  type="button" class="btn btn-secondary" @click="cerrarModal()" >
              Cerrar
            </button>
            <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"  @click="registrarIncidente()">
              Guardar
            </button>
            <button type="button" v-if="tipoAccion == 2" class="btn btn-primary" @click="actualizarIncidente()">
              Actualizar
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      incidente_id: 0,
      incidente: "",
      arrayIncidente: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorIncidente: 0,
      errorMostrarMsjIncidente: [],
      pagination: {
        'total': 0,
        'current_page': 0,
        'per_page': 0,
        'last_page': 0,
        'from': 0,
        'to': 0,
      },
      offset: 3,
      criterio: "tipo_incidente",
      buscar: "",
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  methods: {
    listarIncidente(page, buscar, criterio) {
      let me = this;
      var url =
        "/incidente?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayIncidente = respuesta.incidentes.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //actualizar la pagina actual
      me.pagination.current_page = page;
      //Enviar la peticion para visualizar la data de esa pagina
      me.listarIncidente(page, buscar, criterio);
    },
    registrarIncidente() {
      if (this.validarIncidente()) {
        return;
      }
      let me = this;
      axios
        .post("/incidente/registrar", {
          'tipo_incidente': this.incidente
         
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarIncidente(1, "", 'tipo_incidente');
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarIncidente() {
      if (this.validarIncidente()) {
        return;
      }
      let me = this;
      axios
        .put("/incidente/actualizar", {
          'tipo_incidente': this.incidente,
          'id': this.incidente_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarIncidente(1, "", "tipo_incidente");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    dasactivarIncidente() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Estas seguro?",
          text: "¡No podrás revertir esto!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Sí, bórralo!",
          cancelButtonText: "No, cancelar!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.value) {
            swalWithBootstrapButtons.fire(
              "¡Eliminado!",
              "Su archivo ha sido eliminado.",
              "éxito"
            );
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              "Cancelado",
              "Tu archivo está seguro :)",
              "error"
            );
          }
        });
    },
    validarIncidente() {
      this.errorIncidente= 0;
      this.errorMostrarMsjIncidente = [];

      if (!this.incidente)
        this.errorMostrarMsjIncidente.push(
          "El Tipo de Incidente no puede estar vacio."
        );

      

      if (this.errorMostrarMsjIncidente.length) this.errorIncidente = 1;

      return this.errorIncidente;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.Incidente = "";
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "incidente": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Persona";
              this.incidente = "";
              this.tipoAccion = 1;
              break;
            }

            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualiozar persona";
              this.tipoAccion = 2;
              this.incidente_id = data["id"];
              this.incidente = data["tipo_incidente"];
              break;
            }
          }
        }
      }
    },
  },
  mounted() {
    this.listarIncidente(1, this.buscar, this.criterio);
  },
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important ;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
