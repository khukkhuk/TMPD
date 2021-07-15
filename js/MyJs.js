
        $(document).ready(function () {
            
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            

        });
        function del($id){
            $.ajax({
                type:"POST",
                url:"../api.php",
                data:{
                    id : $id,
                    option : "del",
                },
                success: function(result){
                    alert(result);
                }
            })
        }
        function update($id){
            $.ajax({
                type:"POST",
                url :"../api.php",
                data: 
                {
                    Ename : $("#Ename"+$id).val(),
                    Epassword : $("#Epassword"+$id).val(),
                    Esurname : $("#Esurname"+$id).val(),
                    Eusername : $("#Eusername"+$id).val(),
                    Estatus : $("#Estatus"+$id).val(),
                    Eid : $id,
                    option : "update",
                },
                success: function(result){
                    alert(result);
                }
            });
        
     }

    function getDataFromDb($field,$table,$where)
    {
    $.ajax({ 
                url: "api.php" ,
                type: "POST",
                data: {
                    option: "select",
                    field : $field,
                    table : $table,
                    where : $where,
                }
            })
            .success(function(result) { 
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          $("#myBody").empty();
                          $.each(obj, function(key, val) {


                                    var tr = "<tr>";
                                    tr = tr + "<th scope='row'>" + val["person_id"] + "</th>";
                                    tr = tr + "<th scope='row'>" + val["person_name"] + "</th>";
                                    tr = tr + "<th scope='row'>" + val["person_surname"] + "</th>";
                                    tr = tr + "<th scope='row'>" + val["username"] + "</th>";
                                    tr = tr + "<th scope='row'>" + val["password"] + "</th>";
                                    tr = tr + "<th scope='row'>" + val["ps_name"] + "</th>";
                                    tr = tr + "</tr>";
                                    $('#myTable > tbody:last').append(tr);
                          });
                    }

            });

    }
