<div class="container">
  <br>
  <!-- Boton -->
  <button data-toggle="modal" href="#mi_modal" class="btn btn-primary">Abrir ventana modal</button>
  <br><br>
  <!-- Link -->
  <a data-toggle="modal" href="#mi_modal">Abrir ventana modal</a>

  <!-- si se necesita cambiar tamaño de modal agregar modal-lg a la linea 
  <div class="modal-dialog"> por <div class="modal-dialog modal-lg">-->

  <!-- Modal-->
  <div class="modal fade" id="mi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">TITULO</h4>
        </div>
        <div class="modal-body">
          <div class="row" style="padding:15px">
            ESPACIO PARA TEXTO ESPACIO PARA TEXTO ESPACIO PARA TEXTO ESPACIO PARA TEXTO ESPACIO PARA TEXTO
            ESPACIO PARA TEXTO                   
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>