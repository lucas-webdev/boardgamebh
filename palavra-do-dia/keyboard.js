const keyboard = document.getElementById('keyboard')
const wordsWrapper = document.getElementById('words')
const miliSecondsDay = 1000 * 60 * 60 * 24
let tries = 0
let lettersCount = 0

var wordOfTheDay
var intervalId
var notPresentLetters = []
var uniqueLetters = []
var repeatedLetters = []


document.addEventListener("DOMContentLoaded", function (event)
{

    if (localStorage.getItem('palavra') === wordOfTheDay) showResult(localStorage.getItem('result'))
    else
    {
        localStorage.setItem('result', '')
    }
})

document.querySelectorAll('button.key').forEach(function (input)
{
    input.addEventListener('click', function ()
    {
        if (input.textContent.trim() === 'backspace') eraseLetter()
        if (input.textContent.trim() === 'task_alt') submitTry()

        else
        {
            if (input.innerText.length > 1) return
            if (lettersCount === 5)
                lettersCount = 0
            fillLetter(input.innerText)
        }
    })
})

function fillLetter(letter)
{
    const letterInput = document.querySelectorAll('input.letters:nth-child(' + (parseInt(lettersCount) + 1) + ')')[(tries)]
    if (letter.length >= 1) letterInput.setAttribute('value', '')
    letterInput.setAttribute('value', letter)
    lettersCount += 1
}

function eraseLetter()
{
    const letterInput = document.querySelectorAll('input.letters:nth-child(' + lettersCount + ')')[(tries)]
    letterInput.setAttribute('value', '')
    lettersCount -= 1
}

function submitTry()
{
    const currentTryRow = document.getElementById('try_' + (tries + 1))
    let correctLetters = 0
    let oneLetter = []
    let moreLetters = []
    let failedLetters = []
    let submittedWord = ''

    const tryDiv = document.createElement('div')
    tryDiv.classList.add('d-flex')
    tryDiv.classList.add('align-items-center')
    tryDiv.classList.add('justify-content-center')
    tryDiv.classList.add('mb-4')
    currentTryRow.querySelectorAll('input').forEach(function (input)
    {
        const inputLetter = input.value
        const normalizedWord = wordOfTheDay.normalize('NFD').replace(/[\u0300-\u036f]/g, "")
        const indexes = [...normalizedWord.matchAll(new RegExp(inputLetter, 'gi'))].map(a => a.index)
        const submittedIndex = input.dataset.letterIndex
        const letterDiv = document.createElement('div')
        letterDiv.classList.add('ms-1')
        document.getElementById('summary').appendChild(tryDiv)

        if (indexes.length === 0)
        {
            input.classList.add('not-present')
            notPresentLetters.push(inputLetter)
            failedLetters.push(inputLetter)
            disableLetter(inputLetter)
            letterDiv.classList.add('summary-failure')
            tryDiv.appendChild(letterDiv)
        }
        if (indexes.length === 1)
        {
            if (oneLetter.find((l) => l === inputLetter))
            {
                input.classList.add('not-present')
                disableLetter(inputLetter)
                letterDiv.classList.add('summary-failure')
                tryDiv.appendChild(letterDiv)
            }
            else if (indexes[0] + 1 == submittedIndex)
            {
                input.classList.add('correct')
                replaceLetter(input, wordOfTheDay.charAt(submittedIndex - 1))
                highlightLetter(inputLetter)
                correctLetters += 1
                letterDiv.classList.add('summary-success')
                tryDiv.appendChild(letterDiv)
            }
            else
            {
                input.classList.add('misplaced')
                replaceLetter(input, wordOfTheDay.charAt(submittedIndex - 1))
                highlightLetter(inputLetter)
                letterDiv.classList.add('summary-warning')
                tryDiv.appendChild(letterDiv)
            }

            oneLetter.push(inputLetter)
            uniqueLetters.push(inputLetter)
        }
        if (indexes.length > 1)
        {
            if (moreLetters.length >= indexes.length)
            {
                input.classList.add('not-present')
                disableLetter(inputLetter)
                letterDiv.classList.add('summary-failure')
                tryDiv.appendChild(letterDiv)
            }
            else
            {
                indexes.forEach((ind) =>
                {
                    const submittedIndex = input.dataset.letterIndex
                    if (ind + 1 == submittedIndex)
                    {
                        input.classList.add('correct')
                        correctLetters += 1
                        letterDiv.classList.add('summary-success')
                        tryDiv.appendChild(letterDiv)
                    }
                    else
                    {
                        input.classList.add('misplaced')
                        letterDiv.classList.add('summary-warning')
                        tryDiv.appendChild(letterDiv)
                    }
                    replaceLetter(input, wordOfTheDay.charAt(submittedIndex - 1))
                    highlightLetter(inputLetter)
                })
            }
            moreLetters.push(inputLetter)
            repeatedLetters.push(inputLetter)
        }
        input.classList.add('submitted')

        submittedWord += inputLetter
        localStorage.setItem(`try_${tries}`, submittedWord)

    })

    tries += 1

    if (correctLetters === 5) showResult('success')
    if (tries === 5) showResult('failure')
}

if (!wordOfTheDay) pickWord()

function pickWord()
{
    fetch('https://bgbh.com.br/palavra-do-dia/pickWord.php', {
        headers: {
            'Content-Type': 'application/json'
        }
    }).then((response) => response.json())
        .then((res) => { wordOfTheDay = res.word })
}

function replaceLetter(input, letter)
{
    input.innerText = letter
    input.value = letter

}

function disableLetter(letter)
{
    if (uniqueLetters.find((l) => l === letter)) return
    if (repeatedLetters.find((l) => l === letter)) return
    keyboard.querySelectorAll('.key').forEach((btn) =>
    {
        if (btn.innerText === letter)
        {
            btn.classList.add('disabled')
            btn.setAttribute('disabled', true)
        }
    })
}

function highlightLetter(letter)
{
    if (notPresentLetters.find((l) => l === letter)) return
    keyboard.querySelectorAll('.key').forEach((btn) =>
    {
        if (btn.innerText === letter)
        {
            btn.classList.add('highlight')
        }
    })
}

function showResult(status)
{
    document.getElementById(`result-${status}`).classList.remove('d-none')
    document.getElementById('tries').innerText = tries
    document.getElementById('show-modal').click()
    localStorage.setItem('result', status)
    localStorage.setItem('palavra', wordOfTheDay)
}