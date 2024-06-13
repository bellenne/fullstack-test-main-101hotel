<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h3>Comments:</h3>
        <form method="get" class="w-100" action="/comments/sort">
            <div class="d-flex">
                <select class="custom-select" id="sortByColumn" name="column">
                    <option selected value="id">Sort by</option>
                    <option value="id">ID</option>
                    <option value="date">Date</option>
                </select>
                <select class="custom-select" id="sortByDirection" name="direction">
                    <option selected value="asc">Sorting direction</option>
                    <option value="asc">A-Z</option>
                    <option value="desc">Z-A</option>
                </select>
                <button class="btn btn-outline-primary" id="sort-btn" type="submit">Sort</button>
            </div>
        </form>
        <div id="wrapper" class="w-100">
            <?php if($isEmpty):?>
                <h3>No comments</h3>
            <?php else:?>
                <?=view("layouts/comments_list")?>
            <?php endif?>
        </div>
    </div>


    <div class="container">
        <?php helper('form');?>
    <!-- <form> -->
        <!-- <form action="comments/create" id="form__new-comment" method="post"> -->
        <?= form_open("comments/create",["id"=>"form__new-comment"])?>
        <h4>Add comment</h4>
        <div class="form-group">
            <label for="user-email">E-mail</label>
            <input type="email" required class="form-control" id="user-email" name="name" placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="user-comment">Сomment</label>
            <textarea class="form-control" required id="user-comment" name="text" rows="3"></textarea>
        </div>
        <button class="btn btn-outline-primary" id="newComment" type="submit">Comment</button>
    <!-- </form> -->
        <?= form_close()?>
    <div id="alerts" class="mt-2">
        
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script>
        const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;

        const input = document.getElementById("user-email");

        function onInput() {
            if (isEmailValid(input.value)) {
                input.style.borderColor = 'green';
            } else {
                input.style.borderColor = 'red';
            }
        }

        input.addEventListener('input', onInput);

        function isEmailValid(value) {
            return EMAIL_REGEXP.test(value);
        }
        $(document).on("click", ".removeComment", function(){
            $.ajax({
                    url: '<?=site_url()?>comments/remove',        
                    method: 'post',  
                    type:'post' ,
                    dataType: 'json',        
                    data: {id: $(this).attr("data-id")}, 
                    success: function(data){  
                        $("#wrapper").html(data["html"]);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
        });
       
         $("#form__new-comment").submit(function(e){
            e.preventDefault();
            $("#alerts").html('');
            if (!isEmailValid(input.value)) {
                $(input).focus();   
            }else{
                $.ajax({
                    url: $(this).attr("action"),        
                    method: 'post',    
                    dataType: 'json',        
                    data: $(this).serialize(), 
                    success: function(data){  
                        if(data["id"] == false){
                            Object.entries(data).forEach(entry => {
                                const [key, value] = entry;
                                if(key != "id"){
                                    $("#alerts").append(`
                                    <div class="alert alert-danger mb-2" role="alert">`+
                                    value
                                    +`</div>
                                    `);
                                }
                            });
                        }else{
                            $("#wrapper").html(data["html"]);
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
         });
    </script>
</body>
</html>