
var vm = new Vue({
    el : "#app",
    data:{
        row:{
            reference : 'randomvalue',
            description : 'test description',
            amount : {
                currency : 'COP',
                total : '50000'
            }
        },
        asyncRequestStatus : {
            status : 'Loaded',
            message : ''
        },
        paymentStepProccess:{
            status:''
        },
        checkAllRequests:false,

        processedRequests:[],

        pagina: 1,
        numero: 7,
    },
    methods : {
        asyncRequest(url, data = null, callback = [], API = false) {
            var formData = new FormData();
            if (data != null) {
                var str_data = JSON.stringify(data);
                formData.append("data", str_data);
            }
            axios
                .post(url, formData, {
                    headers: {
                        "Content-type": "multipart/form-data"
                    }
                })
                .then(response => {
                    if (callback.length > 0) {
                        callback.forEach(element => {
                            if (element != null) {
                                element(response.data);
                            }
                        });
                    }
            });
        },

        redondear_numero(num, precision) {
            precision = Math.pow(10, precision);
            return Math.ceil(num * precision) / precision;
        },


        paymentDataReadyToBeProccesed(){
            let answer = "Ok";
            for (const key in this.row) {
                if (this.row.hasOwnProperty(key)) {
                    const element = this.row[key];
                    if(key != 'amount') {
                        if (element.length < 0 || element === ''){
                            alert('You have to fill the form data completely');
                            answer = 'Fail';
                        }
                    }
                    if(key === 'amount') {
                        for (const keyAmount in element) {
                            if (element.hasOwnProperty(keyAmount)) {
                                const elementAmount = element[keyAmount];
                                if (elementAmount.length < 0 || elementAmount === '' ){
                                    alert('You have to fill the form data completely');
                                    answer = 'Fail';
                                }
                                if ( parseInt(elementAmount) <= 0 ){
                                    alert('Amount has to be greater than 0');
                                    answer = 'Fail';
                                }
                            }
                        }
                    }

                }
            }
            return answer;
        },

        askPayment(){
            if ( this.paymentDataReadyToBeProccesed() === "Ok" ) {
                var askForPaymentRequest = confirm( 'Are you sure you want to checkout this payment data ?' );
                if( askForPaymentRequest ) {
                    this.asyncRequestStatus.status = 'isLoading';
                    this.asyncRequest('paymentRequest', this.row, [
                        (paymentRequestResponse) => {
                            this.asyncRequestStatus.requestId = paymentRequestResponse.requestId;
                            this.asyncRequestStatus.status = paymentRequestResponse.status.status;
                            this.asyncRequestStatus.message = paymentRequestResponse.status.message;
                            this.asyncRequestStatus.processUrl = paymentRequestResponse.processUrl;
                            if(paymentRequestResponse){
                                window.open(paymentRequestResponse.processUrl, '_blank');
                            }
                        }
                    ]);
                }
            }
        },

        checkForExisitngPaymentProcess(referenceCode){
            let temporalRow = {};
            temporalRow.referenceCode = referenceCode;
            this.asyncRequest('checkCurrentPaymentProcess', temporalRow, [
                (checkForExisitngPaymentProcessResponse) => {
                    if(checkForExisitngPaymentProcessResponse){
                        console.log( checkForExisitngPaymentProcessResponse );
                        this.paymentStepProccess.status = checkForExisitngPaymentProcessResponse.result.status.status;
                        this.asyncRequestStatus.message = checkForExisitngPaymentProcessResponse.result.status.message;
                        this.asyncRequestStatus.row = checkForExisitngPaymentProcessResponse.row;
                    }
                }
            ]);

        },

        getAllProcessedRequests(){
            this.checkAllRequests =! this.checkAllRequests
            this.asyncRequest('getAllProcessedRequests', null, [
                (getAllProcessedRequestsResponse) => {
                    if(getAllProcessedRequestsResponse){
                        console.log( getAllProcessedRequestsResponse );
                        this.processedRequests = getAllProcessedRequestsResponse;
                    }
                }
            ]);

        },

        createRandomValueForReferenceCode(){
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 13; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
    },
    mounted() {
        this.row.reference = this.createRandomValueForReferenceCode();
        var url_string = window.location.href; //window.location.href
        var url = new URL(url_string);
        var referenceCode = url.searchParams.get("codref");
        if(referenceCode){
            this.row.reference = referenceCode;
            this.checkForExisitngPaymentProcess(referenceCode);
        }
    },
    // options
  })
