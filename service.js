/* global fetch, URLSearchParams,Jcrop*/

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

let name = urlParams.get('name')
let url ='https://informatica.ieszaidinvergeles.org:10048/pia/upload/Aws-FaceRekognition/service.php?name=' + name;

fetch(url,{
    body: "name=" + name,
    headers: {
        "Content-type":"application/x-www-form-urlencoded; charset=UTF-8"
    },
    method: 'post',
    
}).then(function(response) {
    return response.json();
    
}).then(function (data) {
    console.log(data);
    processResponse(data);
    
}).catch(function (error) {
    console.log('Request failed', error);
    
});


function processResponse(caras){
    const img = document.getElementById('imagen');
    
    const imgHeight = img.height
    const imgWidth = img.width
    
    let jcrop = Jcrop.attach('imagen',{
        shadeColor: 'grey',
        multi: true
    });
    
    for (const cara of caras){
        if (cara.low < 18){
            let rect = Jcrop.Rect.create(cara.left * imgWidth, cara.top * imgHeight , cara.width * imgWidth , cara.height * imgHeight)
            jcrop.newWidget(rect,{})
        }
    }
    
    //Prueba de creación de rectangulos
    /*const rect2 = Jcrop.Rect.create(600,400,200,200)//Sustituir por los valores de DetectFaces
    jcrop.newWdiget(rect2,{})*/
}



