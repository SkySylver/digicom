function debounce(callback, delay){
    let timer;
    return function(){
        let args = arguments;
        let context = this;
        clearTimeout(timer);
        timer = setTimeout(function(){
            callback.apply(context, args);
        }, delay)
    }
}

class LinkedSelect{
    /**
     * @param {HTMLSelectElement} $select
     */
    constructor($select){
        this.$select = $select;
        this.$target = document.querySelector(this.$select.dataset.target);
        this.$placeholder = this.$target.firstElementChild;
        this.onChange = debounce(this.onChange.bind(this), 400);
        this.$select.addEventListener('change', this.onChange);
    }

    /**
     * @param {Event} e
     */
    onChange(e){
        // recupere data
        let request = new XMLHttpRequest();
        request.open('GET', this.$select.dataset.source.replace('$id', e.target.value), true);
        request.onload = () =>{
            if(request.status < 400 && request.status >= 200){
                let $data = JSON.parse(request.responseText);
                let options;
                let onc;
                if(this.$target.id === 'result'){
                    options = $data.reduce(function (acc, option) {
                        if(option.on_command) onc = '<span class="text-success">La pièce est disponible en stock</span>';
                        else onc = '<span class="text-warning">La pièce nécessaire à la réparation n\'est pas disponible en stock, celle-ci est donc sur commande.</span>';
                        let time = new Date('2000-01-01T' + option.time);


                        return acc + '<div class="col-sm-12 text-center"><h3>' + option.label + '</h3></div> ' +
                            '<div id="description" class="col-sm-4">' +
                            '<img class="img-thumbnail" src=./img/repairs/' + option.url + ' alt="Image ' + option.name + '">' +
                            '</div>' +
                            '<div class="col-sm-8 border">' +
                            '<h5><u>Description :</u></h5>' +
                            '<p>' + option.description + '<br><br>' +
                            '<span class="text-info"> Temps nécessaire : ' + time.getHours() + ' heure(s) ' + time.getMinutes() + ' minute(s)</span><br>' +
                            onc +
                            '</p>' +

                            '<div class="text-center">' +
                            '<span class="bg-info text-white p-3 rounded">Prix TTC : ' + option.price + '€</span>'
                    }, '');
                    this.$target.innerHTML = options;
                }
                else{
                    options = $data.reduce(function (acc, option) {
                        return acc + '<option value="' + option.value +'">' + option.label + '</option>'
                    }, '');

                    this.$target.innerHTML = options;
                    this.$target.insertBefore(this.$placeholder, this.$target.firstChild);
                    this.$target.selectedIndex = 0;
                    document.getElementById('label-'+this.$target.id).style = null;
                }
                this.$target.style.display = null;
            }
            else{
                request.onerror = alert("Impossible de charger une liste");
            }
        };
        request.send();
    }
}


//recupere les selects liés
let $selects = document.querySelectorAll('.linked-select');

//Creation d'un objet LinkedSelect qui y est lié
$selects.forEach(function ($select){
    new LinkedSelect($select)

    $select.selectedIndex = 0;
});
