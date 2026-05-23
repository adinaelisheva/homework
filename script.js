function markDone(button) {
  fetch(`./markdone.php?id=${button.id}`);
  button.classList.add('hidden');
  button.parentElement.classList.add('done');
  button.parentElement.querySelector('.checkmark').classList.remove('hidden');
  const dateDiv = button.parentElement.querySelector('.duedate');
  dateDiv.innerText = dateDiv.getAttribute('nowdate');
  button.parentElement.setAttribute('style', 'order: 100;');
}

function undoDone(checkmark) {
  fetch(`./undodone.php?id=${checkmark.id}`);
  checkmark.classList.add('hidden');
  checkmark.parentElement.classList.remove('done');
  checkmark.parentElement.querySelector('button').classList.remove('hidden');
  const dateDiv = checkmark.parentElement.querySelector('.duedate');
  if (dateDiv.getAttribute('duedate')) {
    dateDiv.innerText = dateDiv.getAttribute('duedate');
  } else {
    dateDiv.innerText = `${dateDiv.getAttribute('nowdate')}?`;
  }
  checkmark.parentElement.setAttribute('style', '');
}

function addItem() {
  const name = document.querySelector('#name').value;
  const subject = document.querySelector('#subject').value;
  const duedate = document.querySelector('#duedate').value;
  const daily = document.querySelector('#daily').checked;
  if (!name || !subject || (!daily && !duedate)) {
    document.querySelector('.invalid').classList.remove('hidden');
    return;
  } else {
    document.querySelector('.invalid').classList.add('hidden');
  }
  let qStr = `./additem.php?name=${name}&subject=${subject}`;
  if (!daily && duedate) {
    // If the daily box is checked it overrides whatever the due date field is
    qStr += `&due=${duedate}`;
  }
  fetch(qStr);
  document.querySelector('.valid').classList.remove('hidden');
  window.setTimeout(() => {
    window.location.reload();
  }, 1000);
}

function addDatalistOption(text) {
  const option = document.createElement('option');
  option.setAttribute('value', text);
  document.querySelector('#subjectnames').appendChild(option);
}

function setup() {
  for (const subject of document.querySelectorAll('div.subject h3')) {
    addDatalistOption(subject.innerText);
  }
  for (const button of document.querySelectorAll('button.done')) {
    button.addEventListener('click', () => {
      markDone(button);
    });
  }
  for (const checkmark of document.querySelectorAll('.checkmark')) {
    checkmark.addEventListener('click', () => {
      undoDone(checkmark);
    });
  }
  document.querySelector('button.additem').addEventListener('click', () => {
    addItem();
  });
}

window.onload = setup;