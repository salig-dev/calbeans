//-- block of code below --//
const hiddenMenuSections = document.querySelectorAll('.__menu-sub-ctn.d-none');
const listItems = document.querySelectorAll('.nice-select > ul > li');
const contentTextArray = [];
listItems.forEach(function(listItem, index) {
  const contentText = listItem.textContent;
  contentTextArray.push({ text: contentText, value: index });
}); // Store the content of the select option elements for parsing later
let x = document.querySelectorAll('.small-tittle > h4')

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
hideSection();

function main(){
  let selectedValue = getSelectValue();
  selectedValue = compareComboboxValue(selectedValue);
  console.log("This is: " + selectedValue); // For Debugging
  hideSection();
  showSection(selectedValue);
}


function getSelectValue() {
  let selectedValue = document.getElementById("menu-combobox").value;
  // console.log(selectedValue);
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
  const menuSections = document.querySelectorAll('.__menu-sub-ctn'); // Get the menu sections
  menuSections.forEach(function(menuSection) {
    menuSection.classList.add('d-none');
  }); // Hide all the category sections
} // WORKING

function showSection() {
  const listItems = document.querySelectorAll('.nice-select > ul > li.option');

  listItems.forEach(function(listItem, index) {
    if (listItem.classList.contains('selected')) {
      const sectionIndex = index - 1;
      const section = document.querySelector(`.__menu-sub-ctn:nth-child(${sectionIndex})`);
      if (sectionIndex <= 0) {
        console.log("Index " + sectionIndex);
        const menuSections = document.querySelectorAll('.__menu-sub-ctn'); // Get the menu sections
        menuSections.forEach(function(menuSection) {
          menuSection.classList.add('__menu-all');
          menuSection.classList.add('show');
          menuSection.classList.remove('d-none');
        }); // Hide all the category sections
      } else {
        section.classList.add('show');
        section.classList.remove('d-none');
      }
    }
  });
}

