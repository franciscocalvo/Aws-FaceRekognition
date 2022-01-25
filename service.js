/* global fetch, URLSearchParams,Jcrop,jcrop*/


const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

let name = urlParams.get('name');
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


let jcrop = Jcrop.attach('imagen',{
        shadeColor: 'grey',
        multi: true
});

function processResponse(caras){
    const img = document.getElementById('imagen');
    
    const imgHeight = img.height
    const imgWidth = img.width
    
    
    for (const cara of caras){
        if (cara.low < 18){
            let rect = Jcrop.Rect.create(cara.left * imgWidth, cara.top * imgHeight , cara.width * imgWidth , cara.height * imgHeight)
            jcrop.newWidget(rect,{})
        }
    }
    
    
}


function addInput(name, value,fblur) {
    let element = document.createElement("input");
    element.name = name + '[]';
    element.type = 'hidden';
    element.value = value;
    element.form = 'fblur';
    fblur.appendChild(element);
}

let fblur = document.getElementById('fblur');
fblur.addEventListener("submit", function(){
    for (const crop of jcrop.crops){
        addInput('x', crop.pos.x, fblur);
        addInput('y', crop.pos.y, fblur);
        addInput('w', crop.pos.w, fblur);
        addInput('h', crop.pos.h, fblur);
    }
});

