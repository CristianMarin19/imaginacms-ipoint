@extends('layouts.master')

@section('title')
  Ipoint | @parent
@stop


@section('content')
<div class="ipoint_payment ipoint_payment_index py-5">
<div id="content_ipoint">
  <div class="container">
  
    <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">Bienvenido - Pagar orden con tus puntos</h5>
        <div class="card-body">

          
          <div v-if="!finished">
            @include('ipoint::frontend.payment.partials.information')
          </div>
          <div v-if="finished">
            @include('ipoint::frontend.payment.partials.approved')
          </div>
         

          @if(!$resultValidate['processPayment'])
            <div class="alert alert-danger" role="alert">
              No posee el Puntos Suficientes para realizar el pago
            </div>
          @else

            <div v-if="!finished" class="btn-payment text-center">
               @include("icredit::frontend.payment.partials.loading")
               <button 
                v-if="!loading"
                type="button" 
                class="btn btn-primary text-uppercase font-weight-bold" 
                v-on:click="processPayment">Pagar</button>
            </div>
            
          @endif
          

        </div>
      </div>

     </div>
  </div>
</div>
</div>
@stop

@section('scripts')
@parent

<script type="text/javascript">

var index_ipoint = new Vue({
  el: '#content_ipoint',
  created() {
    this.$nextTick(function () {
      this.init();
    })
  },
  data: {
    success: false,
    loading: false,
    encrp: '{{$eURL}}',
    dataPayment:null,
    finished: false
  }, 
  methods: {
    init(){
      this.success = true;
    },
    finishedPayment(){
     
      let redirect = "{{$order->url}}";
      
      setTimeout(function () {
        window.location.href = redirect;
      }, 3000);
      
    },
    processPayment(){
      
      this.loading = true;
      let path = "{{route('ipoint.api.payment.processPayment')}}"
      let attributes2 = {
        encrp:this.encrp
      }

      axios.post(path, {attributes:attributes2})
      .then(response => {

        if(response.data.success){
           this.dataPayment = response.data.data;
           this.finished = true;
           this.finishedPayment();
        }

      })
      .catch(error => {

        alert("Error - Comuniquese con el administrador")
        console.log(error)

      })
      .finally(() => this.loading = false)
      
    }
  }
  
  
})

</script>



@stop