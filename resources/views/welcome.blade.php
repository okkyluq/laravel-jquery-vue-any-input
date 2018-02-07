<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <title>Laravel</title>
        <!-- Fonts -->
        <style>
    </style>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body >
        <div class="flex-center position-ref full-height" id="app">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Data Kryawan</div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="nm_karyawan" placeholder="nama karyawan">
                                <input type="text" class="form-control" id="nik" placeholder="nik" readonly>
                                <input type="text" class="form-control" id="tpt_lahir" placeholder="tempat_lahir" readonly>
                                <br>
                                <input type="text" class="form-control" v-model='key' v-on:keyup="filter">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>NAMA</th>
                                            <th>Tgl _lahir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items">
                                            <td>@{{ item.nik }}</td>
                                            <td>@{{ item.nm_karyawan }}</td>
                                            <td>@{{ item.tgl_lahir }}</td>
                                        </tr>
                                    </tbody>
                              </table>
                              <div class="text-left">
                                  
                              </div>
                              <div class="text-right">
                                  <ul class="pagination">
                                      <li><button type="button" class="btn btn-sm btn-info" v-on:click="prevKaryawan" :disabled="!this.prev">Prev</button></li>
                                      <li><button type="button" class="btn btn-sm btn-info" v-on:click="nextKaryawan" :disabled="!this.next">Next</button></li>

                                  </ul>
                              </div>
                              <div class="jumbotron" v-if="showJumbo">
                                  <h1>Hello world</h1>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nm_karyawan').autocomplete({
                source: "search/autocomplete",
                minLength: 3,
                select: function( event, ui ) { 
                    $( "#nm_karyawan" ).val( ui.item.nm_karyawan );
                    $( "#tpt_lahir" ).val( ui.item.tpt_lahir );
                    $( "#nik" ).val( ui.item.nik );
                    return false;
                },
                // change: function( event, ui ) {
                //     alert('hello');
                //     $( "#nm_karyawan" ).val("");
                //     $( "#tpt_lahir" ).val("");
                //     $( "#nik" ).val("");
                // },
                // search: function( event, ui ) {
                //     $( "#nm_karyawan" ).val("");
                //     $( "#tpt_lahir" ).val("");
                //     $( "#nik" ).val("");
                // },
                // open: function( event, ui ) {
                //     $( "#nm_karyawan" ).val("");
                //     $( "#tpt_lahir" ).val("");
                //     $( "#nik" ).val("");
                // }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
             return $( "<li>" ) .append( "<div>" + item.nm_karyawan + " | " + item.nik + "</div>" ) .appendTo(ul);
            };

        });


        new Vue({
            el:'#app',
            data : {
                message :'',
                text:'',
                items:[],
                key:'',
                prev: '',
                next:'',
                showJumbo: false,
            },
            mounted() {
                this.getKaryawan();
            },
            methods: {
                getKaryawan(){
                    var vm = this;
                    axios.get("/data/karyawan")
                    .then(function(respon){
                        vm.items = respon.data.data;
                        vm.prev = respon.data.prev_page_url;
                        vm.next = respon.data.next_page_url;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                },
                prevKaryawan(){
                    var vm = this;
                    axios.get(this.prev)
                    .then(function(respon){
                        vm.items = respon.data.data;
                        vm.prev = respon.data.prev_page_url;
                        vm.next = respon.data.next_page_url;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                },
                nextKaryawan(){
                    var vm = this;
                    axios.get(this.next)
                    .then(function(respon){
                        vm.items = respon.data.data;
                        vm.prev = respon.data.prev_page_url;
                        vm.next = respon.data.next_page_url;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                },
                filter(){
                    var vm = this;
                    axios.get("/data/karyawan"+"?cari="+this.key)
                    .then(function(respon){
                        vm.items = respon.data.data;
                        vm.prev = respon.data.prev_page_url;
                        vm.next = respon.data.next_page_url;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },
        });
    </script>
</html>
