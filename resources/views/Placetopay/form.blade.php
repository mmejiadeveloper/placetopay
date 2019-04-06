<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>Place to pay form</title>
</head>
<body>
    <div class="card" id="app">
        <div class="card-header">
            <h2>Payment data (please fill out this form completely) </h2>
            <b>Important note: make sure your browser allow pop ups to this site in order to be redirect to the P2P payment site.</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="form-group">
                      <label for="">Reference Value (*)</label>
                      <input  title="The reason i blocked this is becuase i dont allow the user have the chance to change the value and then this value match with some existing in the database" disabled v-model = "row.reference" type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label for="">Payment currency</label>
                        <select :disabled = "asyncRequestStatus.status === 'isLoading' || paymentStepProccess.status == 'PENDING' " v-model = "row.amount.currency" class="form-control" name="" id="">
                            <option value="" >Select</option>
                            <option value="COP" >COP</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input :disabled = "asyncRequestStatus.status === 'isLoading' || paymentStepProccess.status == 'PENDING' " v-model = "row.amount.total" type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label for="">Description (*)</label>
                        <textarea :disabled = "asyncRequestStatus.status === 'isLoading' || paymentStepProccess.status == 'PENDING' " v-model = "row.description" class="form-control" name="" id="" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <button v-if=" paymentStepProccess.status == '' || paymentStepProccess.status == 'APPROVED' "  :disabled = "asyncRequestStatus.status === 'isLoading' || paymentStepProccess.status == 'PENDING' " @click="askPayment()" type="button" class="btn btn-primary">Checkout</button>
                    <button v-if=" paymentStepProccess.status == 'REJECTED' "  @click="location.href = 'http://desarrollo.p2p.com'" type="button" class="btn btn-primary">New Payment Request</button>
                    <span v-if = "asyncRequestStatus.message.length > 0 ">
                        @{{
                            asyncRequestStatus.message
                        }}
                        <span  v-if = "asyncRequestStatus.status === 'OK' ">
                            .However, if you browser is not loading payment pop up you can go to payment by clicking this link. <a target="_blank" :href="asyncRequestStatus.processUrl"> Go to payment </a>
                        </span>
                    </span>
                    <span v-if = "paymentStepProccess.status == 'PENDING'  ">
                        <span  >
                        . This payment request status is <b>@{{ paymentStepProccess.status }}</b>. You can go back to the payment page to continue with your payment. <a target="_blank" :href="asyncRequestStatus.row.processUrl"> Go to payment </a>
                        </span>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <a @click.prevent = "getAllProcessedRequests()" href="#">
                        <span v-if='!checkAllRequests'>Check</span>
                        <span v-else='checkAllRequests'>Hide</span>
                        payment requests
                    </a>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-12" v-if='checkAllRequests'>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Reference Value</th>
                                <th>Status</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for = "(request, index) in processedRequests" v-show="(pagina-1)*numero <= index && pagina*numero > index">
                                <td> @{{ request.requestId }} </td>
                                <td> @{{ request.referenceValue }} </td>
                                <td> @{{ request.status }} </td>
                                <td> <a :href="request.processUrl" target="_blank" > @{{ request.processUrl }}</a> </td>
                            </tr>
                            <tr v-if = "processedRequests.length <= 0" >
                                <td colspan="4"> There is not results to show</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="paginador" v-if="processedRequests.length > 0">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displaypaginador"  >
                            P&aacute;gina actual: @{{ pagina }}
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 "  >
                            <a :class=" [ pagina!=1 ? '' : 'paginador-disabled']  "href="#" @click.prevent="pagina=1"  ><i class="fas fa-backward  icustom2"></i></a>
                            <a :class=" [ pagina!=1 ? '' : 'paginador-disabled'] " href="#" @click.prevent="pagina=pagina-1"  ><i class="fas fa-arrow-circle-left icustom2"></i></a>
                            <a :class=" [ (pagina*numero)/(processedRequests.length) < 1 ? '' : 'paginador-disabled'] "href="#" @click.prevent="pagina=pagina+1"  ><i class="fas fa-arrow-circle-right icustom2"></i></a>
                            <a :class=" [ (pagina*numero)/(processedRequests.length) < 1 ? '' : 'paginador-disabled']" href="#" @click.prevent="pagina=redondear_numero(processedRequests.length/numero, 0 )"  ><i class="fas fa-forward icustom2"></i></a>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <script src="public/js/placetopaytest/appvue.js"></script>
</body>
</html>
<style>

.paginador {
    margin-top: 12px;
    text-align: center;
    font-size: 23px;
}

.paginador-disabled {
    pointer-events: none !important;
    color: #c2c2c2 !important;
}

.displaypaginador {
    font-size: 15px;
    margin-bottom: 10px;
}

</style>
