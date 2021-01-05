var elem = document.querySelector('.post-list')
var img = [];
function recursy(elem) {
    elem.childNodes.forEach(node => {
        if (node.nodeName === 'A') {
            img.push(node.innerHTML.match(/https.+g/)[0])
        } else {
            recursy(node)
        }      
    })
}
recursy(elem)
fetch('http://php/img.php', {
    method: 'POST',
    headers: {
        "Content-Type": "application/json;odata=verbose"
    },
    body: JSON.stringify(img)
})

var pages = document.querySelector('.page-item')