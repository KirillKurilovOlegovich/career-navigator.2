// Assuming you have jQuery for simplicity.  You could use vanilla JS fetch instead.
$('#addQuestionBtn').click(function() {
    let questionCount = $('.question-item').length;
    let newQuestionHTML = `
        <div class="question-item flex items-center max-md:flex-col gap-4 w-full mb-4">
            <label for="question_${questionCount}">Вопрос:</label>
            <input type="text" name="questions[${questionCount}][question_text]" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2" placeholder="Вопрос">
            <label for="answer_${questionCount}">Ответ:</label>
            <input type="text" name="questions[${questionCount}][correct_answer]" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2" placeholder="Ответ">
        </div>
    `;
    $('#questionContainer').append(newQuestionHTML);
});


//  Axios function to save questions (this should be triggered by a button or form submission)
$('#testForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = $(this).serialize(); // Serialize the form data

    axios.post('/your-route-to-handle-questions', formData) // Replace with your actual route
        .then(response => {
            console.log('Questions saved successfully:', response.data);
            // Optionally, redirect or display a success message
            //Example:  window.location.href = '/quizzes'; // Redirect to a quizzes page
            alert('Вопросы сохранены!');
        })
        .catch(error => {
            console.error('Error saving questions:', error);
            // Handle errors appropriately (display error messages to the user)
            alert('Ошибка при сохранении вопросов!');
        });
});