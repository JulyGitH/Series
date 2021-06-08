window.onload=init;

function init(){

    let buttons = Array.from(document.getElementsByClassName('likeCount'));
    let serieId = document.getElementById('serieId').value;

    console.log(buttons);
    console.log(serieId);

    buttons.forEach(function(element, index){

        element.addEventListener('click', function(){

            let data = {'serieId' : serieId, 'like': element.value};
            console.log(data);

            fetch('ajax_like', {method: 'POST', body: JSON.stringify(data)})
                .then(function (response){
                    return response.json();
                })
                .then(function (data){
                    document.getElementById('nbLikes').innerHTML = ''+data.likes+' likes';
                });

            /*
            //Autre manière

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "ajax_like");
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xmlhttp.onload = function (){
                let data = JSON.parse(this.responseText);
                document.getElementById('nbLikes').innerHTML = ''+data.likes+' likes';
            }

            xmlhttp.send(JSON.stringify(data));
            */
        });
    });

}
