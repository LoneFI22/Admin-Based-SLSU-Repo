    <style>
        .adduser{
            font-size: 50px; 
            border-radius: 50%;
            color: #d1b799;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .adduser:hover{
            opacity: 0.8;
        }
        .adduser:active{
            opacity: 0.4;
        }
        .mycontainer{
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-box {
            width: 300px;
            height: 50px;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-box input[type="text"] {
            border-radius: 8px;
            border: none;
            outline: none;
            flex: 1;
            padding: 8px;
        }
        .profile_fit{
            object-fit: cover;
            border-radius: 50%;
        }

        .search-box button {
            border: none;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 20px 8px 20px 8px;
            cursor: pointer;
        }
        .delete_icon{
            cursor: pointer;
        }
        .like_icon{
            cursor: pointer;
        }
        .borderpage{
            border-radius: 25px;
        }
    </style>
<main>
    <div class="header">
        <div class="left">
            <h1>Repo</h1>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col s12 m8" style="padding: 10px;">
            </div>
            <div class="col s12 m4" style="padding: 10px;">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>
    </div>
    <ul style="margin-top: 10px;">
        <div class="collapsible load_file row white" style="padding: 10px; border-radius: 20px;">

        </div>
    </ul>
</main>

<script>
    $(document).ready(function(){
        function loadFile(){
            $.ajax({
                type: 'GET',
                url: 'user_ajax.php',
                dataType: 'json',
                data: {contentFile: 'contentFile'},
                success: function(response){
                    var loadFile = '';

                    response.forEach(function(item){
                        loadFile += '<li class="col s12 m4">';
                        loadFile += '<div class="borderpage card grey lighten-5 collapsible-header">';
                        loadFile += '<span>';
                        loadFile += '<p>'+item.file_name+'</p>';
                        loadFile += '<small>'+item.file_type+'</small>';
                        loadFile += '</span>';
                        loadFile += '</div>';
                        loadFile += '<div class="borderpage card grey lighten-4 collapsible-body">';
                        loadFile += '<p>Date: '+item.date+'</p>';
                        loadFile += '<p>Downloads: '+item.download_count+'</p>';
                        loadFile += '<p>Likes: '+item.like_count+'</p>';
                        loadFile +='<div style="display: flex; justify-content: space-between;">';
                        loadFile += '<div class="like_icon" data-id="'+item.id+'" onclick="likeButton('+item.id+')" style="border-radius: 20px;"><span><i class="bx bx-like"></i></span></div>';
                        loadFile += '<button class="waves-effect waves-light btn" onclick="downloadButton('+item.id+')" style="border-radius: 20px;">Download</button>';
                        loadFile +='</div>';
                        loadFile += '</div>';
                        loadFile += '</li>';
                    });
                    $('.load_file').html(loadFile);

                    $('.collapsible').collapsible();
                }
            });
        }
        loadFile();
        
        $('#searchInput').on('input',function(){
            const search = $(this).val();
            
            $.ajax({
                type: 'GET',
                url: 'user_ajax.php',
                dataType: 'json',
                data: {searchFile: search},
                success: function(response){
                    var loadFile = '';
        
                    response.forEach(function(item){
                        loadFile += '<li class="col s12 m4">';
                        loadFile += '<div class="borderpage card grey lighten-5 collapsible-header">';
                        loadFile += '<span>';
                        loadFile += '<p>'+item.file_name+'</p>';
                        loadFile += '<small>'+item.file_type+'</small>';
                        loadFile += '</span>';
                        loadFile += '</div>';
                        loadFile += '<div class="borderpage card grey lighten-4 collapsible-body">';
                        loadFile += '<p>Date: '+item.date+'</p>';
                        loadFile += '<p>Downloads: '+item.download_count+'</p>';
                        loadFile += '<p>Likes: '+item.like_count+'</p>';
                        loadFile +='<div style="display: flex; justify-content: space-between;">';
                        loadFile += '<div class="like_icon" data-id="'+item.id+'" onclick="likeButton('+item.id+')" style="border-radius: 20px;"><span><i class="bx bx-like"></i></span></div>';
                        loadFile += '<button class="waves-effect waves-light btn" onclick="downloadButton('+item.id+')" style="border-radius: 20px;">Download</button>';
                        loadFile +='</div>';
                        loadFile += '</div>';
                        loadFile += '</li>';
                    });
                    $('.load_file').html(loadFile);
        
                    $('.collapsible').collapsible();
                    
                }
            });
        });
    });
    function downloadButton(id){
        const download = id;

        window.location.href="user_ajax.php?download="+download+"";
    }
    function likeButton(id){
        const likeId = id;
        console.log(likeId);
        $.ajax({
            type: 'GET',
            url: 'user_ajax.php',
            data: {likeId: likeId},
            success: function(response){
                console.log(response);
                if(response == 'True'){
                    M.toast({html: 'Like File', classes: 'rounded green'});
                    
                    setTimeout(function(){
                        window.location.href="index.php";
                    },1000);
                }else{
                    M.toast({html: 'UnLike File', classes: 'rounded green'});
                    setTimeout(function(){
                        window.location.href="index.php";
                    },1000);
                }
            }
        });
    }
</script>