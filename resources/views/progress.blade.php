<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <!-- Styles -->
        <style>

        </style>
    </head>
    <body class="antialiased">
        @component('components.header')
        @endcomponent


    <div class="container mt-5" id="app">

        <h2>@{{progress}}</h2>
        <hr>
        <h5>@{{pageTitle}}</h5>

        <hr>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar"
              :aria-valuenow="progressPercentage"
              aria-valuemin="0"
              aria-valuemax="100"
              :style="`width: ${progressPercentage}%;`">
             @{{progressPercentage}}%
            </div>
          </div>
    </div>



    <script src="https://unpkg.com/vue@3"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script type="text/javascript">

        const app = {
            data(){
                return {
                    progress:'Welcome to progress page',
                    pageTitle:'Progress Of Uploads',
                    progressPercentage:0,
                    params:{
                        id:null
                    }
                }
            },
            methods:{
                chechIfIdPresent(){
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const params = Object.fromEntries(urlSearchParams.entries());

                    if(params.id){
                        this.params.id = params.id;
                    }
                },
                getUploadProgress(){
                    let self = this;
                    self.chechIfIdPresent();

                    //get progressdata

                    let progressResponse = setInterval(() => {
                        axios.get('/progress/data',{
                            params:{
                                id: self.params.id ? self.params.id :
                                "{{session()->get('lastBatchId')}}",
                            }
                        }).then(function(response){
                            console.log(response.data);



                            let totalJobs = ParseInt(response.data.total_jobs);
                            let pendingJobs = ParseInt(response.data.pending_jobs);
                            let completedJobs = totalJobs - pendingJobs;


                            if(pendingJobs == 0){
                                self.progressPercentage = 100;
                            }
                            else
                            {
                                self.progressPercentage =
                                parseInt(completedJobs/totalJobs * 100).toFixed(0);
                            }

                            if(parseInt(self.progressPercentage)>=100)
                            {
                                clearInterval(progressResponse);
                            }
                        });
                 }, 1000);
                }
            },
            created(){
                this.chechIfIdPresent();
            }
        }

        Vue.createApp(app).mount("#app");
    </script>
    </body>
</html>
