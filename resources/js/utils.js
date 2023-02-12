export const removeDuplicates = (arr, key) => {
    return arr.reduce((unique, o) => {
        if (!unique.some(obj => obj[key] === o[key] && obj.value === o.value)) {
          unique.push(o);
        }
        return unique;
    },[]);
}

export const resetFilter = target => {
    const selects = Array.from(target.closest('.filter').querySelectorAll('select'));
    selects.map(element => (target !== element) ? element.value = 0 : '');
}