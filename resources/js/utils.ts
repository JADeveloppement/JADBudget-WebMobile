const urlArthurivan = 'https://arthurivan.com';
const urlInnersens = 'https://jeremyvalance.com';
const urlContrechamp = 'https://contrechamp.art';

const TYPE_INVOICE = 'INVOICE';
const TYPE_INCOME = 'INCOME';
const TYPE_EXPENSE = 'EXPENSE';
const TYPE_MODELINVOICE = 'MODELINVOICE';
const TYPE_MODELINCOME = 'MODELINCOME';

function makeToast(icon :string, message :string, time :number = 1500, callback? :() =>  void) :void{
    const toastField:HTMLElement|null = document.querySelector<HTMLElement>('.toast')||null;
    const toastIconField:HTMLImageElement|null = toastField?.querySelector<HTMLImageElement>('img') || null;
    const toastMessageField:HTMLParagraphElement|null = toastField?.querySelector<HTMLParagraphElement>('p') || null;

    if (!toastField){
        console.warn('No toastField found');
        return;
    }

    if (!toastIconField){
        console.warn('No toastIconField found');
        return;
    }

    if (!toastMessageField){
        console.warn('No toastMessageField found');
        return;
    }

    toastField.style.bottom = "1rem";
    toastField.style.opacity = "100";
    toastIconField.src = `/storage/${icon}`;
    toastMessageField.innerHTML = message;

    setTimeout(() => {
        toastField.style.bottom = "-300px";
        toastField.style.opacity = "0";

        if (callback) callback();

    }, time)
}

function fetch_result(url, d): Promise<Response>{
    return fetch(url, {
        method: "POST",
        headers: {
            "Content-type" : "application/json"
        },
        body: JSON.stringify(d)
    }).then(response => {
        return response ;
    }).catch(error => {
        return error;
    });
}

function toggleElement(...element:[HTMLElement|null]):void{
    element.forEach((item:HTMLElement|null) => {
        if (!item) return;
        if (item.classList.contains('hidden'))
            item.classList.remove('hidden')
        else item.classList.add('hidden')
    })
}

function toggleElementsWithFlex(...elements:[HTMLElement|null]):void{
    elements.forEach((item:HTMLElement|null) => {
        toggleElement(item);
        if (!item) return;
        if (item.classList.contains('flex')){
            item.classList.remove('flex')
        }
        else {
            item.classList.add('flex')
        }
    })
}

function enableFields(enabled: boolean, ...items: (HTMLElement|null)[]):void{
    items.forEach((item:HTMLElement|null) => {
        if (item){
            if (!enabled) item.setAttribute('disabled', "true");
            else item.removeAttribute('disabled');
        }
    })  
}

export {fetch_result, makeToast, toggleElement, toggleElementsWithFlex, enableFields,
    urlArthurivan, urlInnersens, urlContrechamp,
    TYPE_INVOICE, TYPE_INCOME, TYPE_EXPENSE, TYPE_MODELINCOME, TYPE_MODELINVOICE}