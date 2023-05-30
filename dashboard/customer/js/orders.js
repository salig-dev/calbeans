let listItems;
// Fixes DOM Loading Bug: setTimeout() to allow the document to load before being stored
setTimeout(function() { listItems = document.querySelectorAll('.nice-select > ul > li');}, 200);

const contentTextArray = [];
setTimeout(function() { 
    listItems.forEach(function(listItem, index) {
    const contentText = listItem.textContent;
    contentTextArray.push({ text: contentText, value: index });
  }); // Store the content of the select option elements for parsing later
}, 300);


////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

// hideSection();

function main(){
  let selectedValue = getSelectValue();
  selectedValue = compareComboboxValue(selectedValue);
  // ### For Debugging: console.log("This is: " + selectedValue); 
  hideSection();
  showSection();
}

function getSelectValue() {
  let selectedValue = document.getElementById("menu-combobox").value;
  // ### For Debugging: console.log("Selected value from menu combo-box: " + selectedValue);
  return selectedValue;
}

function compareComboboxValue(selectedValue) {
  let nice_select = document.querySelector('.nice-select > span').textContent;
  console.log('Nice select:', nice_select);
  if (selectedValue === nice_select) {
    const foundObject = contentTextArray.find(obj => obj.text === nice_select);
    if (foundObject) {
      console.log('Object found:', foundObject); // For Debugging
      return foundObject.value;
    } else {
      console.log('Object not found'); // For Debugging
      return null; // when object not found
    }
  } else {
    return null; // when selectedValue doesn't match nice_select
  }
}

function hideSection(){
  const menuSections = document.querySelectorAll('.prod_category_row'); // Get the menu sections
  menuSections.forEach(function(menuSection) {
    menuSection.classList.add('d-none');
  }); // Hide all the category sections
} // WORKING

function showSection() {
  let listItems;
  setTimeout(function() { listItems = document.querySelectorAll('.nice-select > ul > li.option');   
  listItems.forEach(item => { console.log("Test: " + item.textContent); });

  listItems.forEach(function(listItem, index) {
    if (listItem.classList.contains('selected')) {
      const sectionIndex = index - 1;
      // ### For Debugging: console.log("Option Selection index: " + sectionIndex);
      compareValue(sectionIndex);
    }
  });

}, 50);
}

function compareValue(sectionIndex){
  const menuSections = document.querySelectorAll('.prod_category_row'); // Get all menu sections
  let selectedValue = document.querySelector('.nice-select > span').textContent;

  menuSections.forEach(function(menuSection) {
    const value = menuSection.getAttribute("value");
    if (sectionIndex <= 0){
      // ### For Debugging: console.log("Index " + sectionIndex);
      menuSections.forEach(function(menuSection) {
        menuSection.classList.add('show');
        menuSection.classList.remove('d-none');
      }); // Hide all the category sections

    } else{
      // ### For Debugging: console.log("selectedValue. " +  selectedValue)
      // ### For Debugging: console.log("value: " +  value)
      if (value === selectedValue) {
        menuSection.classList.add('show');
        menuSection.classList.remove('d-none');
  
      } else {
        menuSection.classList.remove('show');
        menuSection.classList.add('d-none');
      }
    }
  });
}