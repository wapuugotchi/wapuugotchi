
class Wapuu {

  constructor() {
    this.set_image();
  }

  set_image() {
    let div = document.createElement('DIV');
    div.id = 'wapuugotchi';
    div.innerHTML = wpPluginParam.wapuu;

    document.getElementById('wpwrap').append(div);
  }
}

new Wapuu();