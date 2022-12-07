var $progressValue = 0;
var resultList=[];


const quizdata=[
      {
        question:"What Is the name of the fictional town in Indiana where the show is set?",
        options:["Houston", "Hanford", "Hamilton", "Hawkins"],
        answer:"Hawkins",
        category:1
      },
      {
        question:"In the first episode of the series, four friends including Will were playing a fantasy tabletop RPG game. What is the name of it?",
        options:["Blades in the Dark", "Dungeons & Dragons", "Bubblegumshoe", "Star Trek Adventures"],
        answer:"Dungeons & Dragons",
        category:2
      },
      {
        question:"What is the alternate dimension in Stranger Things named?",
        options:["The Upside Down", "Strangers In", "Demogorgon", "Mind Flayer"],
        answer:"The Upside Down",
        category:3
      },
      {
        question:"Eleven is well-known for eating a specific food; what food is it?",
        options:["Maple Syrup", "Eggo Waffles", "French Fries", "Strawberry Ice Cream"],
        answer:"Eggo Waffles",
        category:1
      },
      {
        question:"In what month and year does Will Byers go missing?",
        options:["September 1983", "November 1984", "December 1985", "November 1983"],
        answer:"November 1983",
        category:2
      },
      {
        question:"What is the brand of soda that is on the can which Eleven crushes with her mind?",
        options:["Coca-cola", "Pepsi", "Mountain Dew", "Sprite"],
        answer:"Coca-cola",
        category:3
      },
      {
        question:"The rural back road Eleven and the boys often use as an escape route is called?",
        options:["Martland", "Mirkwood", "Martwood", "Mirkland"],
        answer:"Mirkwood",
        category:2
      },
      {
        question:"Who is the creature who has supreme control of the Upside Down in Stranger Things?",
        options:["Demogorgon", "The Mind Flayer", "Spider Monster", "Vecna"],
        answer:"The Mind Flayer",
        category:3
      },
      {
        question:"Who has a turtle called Yertle?",
        options:["Dustin", "Mike", "Will", "Lucas"],
        answer:"Dustin",
        category:1
      },
      {
        question:"How old was Will Byers when he disappeared?",
        options:["10", "12", "8", "13"],
        answer:"12",
        category:2
      },
      {
        question:"What is Eleven’s birth name?",
        options:["Jane Hopper", "Jane Ives", "Jane Byers", "Jane Wheeler"],
        answer:"Jane Ives",
        category:3
      },
      {
        question:"Who is the second person captured and killed by the Demogorgon?",
        options:["Barbara Holland", "Bob Newby", "Heather Holloway", "Billy Hargrove"],
        answer:"Barbara Holland",
        category:1
      }
    ];
/** Random shuffle questions **/
function shuffleArray(question){
   var shuffled=question.sort(function() {
    return .5 - Math.random();
 });
   return shuffled;
}

function shuffle(a) {
  for (var i = a.length; i; i--) {
    var j = Math.floor(Math.random() * i);
    var _ref = [a[j], a[i - 1]];
    a[i - 1] = _ref[0];
    a[j] = _ref[1];
  }
}

/*** Return shuffled question ***/
function generateQuestions(){
  var questions=shuffleArray(quizdata);    
  return questions;
}

/*** Return list of options ***/
function returnOptionList(opts, i){

  var optionHtml='<li class="myoptions">'+
    '<input value="'+opts+'" name="optRdBtn" type="radio" id="rd_'+i+'">'+
    '<label for="rd_'+i+'">'+opts+'</label>'+
    '<div class="bullet">'+
      '<div class="line zero"></div>'+
      '<div class="line one"></div>'+
      '<div class="line two"></div>'+
      '<div class="line three"></div>'+
      '<div class="line four"></div>'+
      '<div class="line five"></div>'+
      '<div class="line six"></div>'+
      '<div class="line seven"></div>'+
    '</div>'+
  '</li>';

  return optionHtml;
}

/** Render Options **/
function renderOptions(optionList){
  var ulContainer=$('<ul>').attr('id','optionList');
  for (var i = 0, len = optionList.length; i < len; i++) {
    var optionContainer=returnOptionList(optionList[i], i)
    ulContainer.append(optionContainer);
  }
  $(".answerOptions").html('').append(ulContainer);
}

/** Render question **/
function renderQuestion(question){
  $(".question").html("<h1>"+question+"</h1>");
}

/** Render quiz :: Question and option **/
function renderQuiz(questions, index){ 
  var currentQuest=questions[index];  
  renderQuestion(currentQuest.question); 
  renderOptions(currentQuest.options); 
  console.log("Question");
  console.log(questions[index]);
}

/** Return correct answer of a question ***/
function getCorrectAnswer(questions, index){
  return questions[index].answer;
}

/** pushanswers in array **/
function correctAnswerArray(resultByCat){
  var arrayForChart=[];
  for(var i=0; i<resultByCat.length;i++){
   arrayForChart.push(resultByCat[i].correctanswer);
  }

  return arrayForChart;
}
/** Generate array for percentage calculation **/
function genResultArray(results, wrong){
  var resultByCat = resultByCategory(results);
  var arrayForChart=correctAnswerArray(resultByCat);
  arrayForChart.push(wrong);
  return arrayForChart
}

/** percentage Calculation **/
function percentCalculation(array, total){
  var percent = array.map(function (d, i) {
    return (100 * d / total).toFixed(2);
  });
  return percent;
}

/*** Get percentage for chart **/
function getPercentage(resultByCat, wrong){
  var totalNumber=resultList.length;
  var wrongAnwer=wrong;
  //var arrayForChart=genResultArray(resultByCat, wrong);
  //return percentCalculation(arrayForChart, totalNumber);
}

/** count right and wrong answer number **/
function countAnswers(results){

  var countCorrect=0, countWrong=0;

  for(var i=0;i<results.length;i++){
    if(results[i].iscorrect==true)  
        countCorrect++;
    else countWrong++;
  }

  return [countCorrect, countWrong];
}

/**** Categorize result *****/
function resultByCategory(results){

  var categoryCount = [];
  var ctArray=results.reduce(function (res, value) {
    if (!res[value.category]) {
        res[value.category] = {
            category: value.category,
            correctanswer: 0           
        };
        categoryCount.push(res[value.category])
    }
    var val=(value.iscorrect==true)?1:0;
    res[value.category].correctanswer += val; 
    return res;
  }, {});

  categoryCount.sort(function(a,b) {
    return a.category - b.category;
  });

  return categoryCount;
}


/** Total score pie chart**/
function totalPieChart(_upto, _cir_progress_id, _correct, _incorrect) {

   $("#"+_cir_progress_id).find("._text_incor").html("Incorrect : "+_incorrect);
   $("#"+_cir_progress_id).find("._text_cor").html("Correct : "+_correct);

   var unchnagedPer=_upto;
   
    _upto = (_upto > 100) ? 100 : ((_upto < 0) ? 0 : _upto);

    var _progress = 0;

    var _cir_progress = $("#"+_cir_progress_id).find("._cir_P_y");
    var _text_percentage = $("#"+_cir_progress_id).find("._cir_Per");

    var _input_percentage;
    var _percentage;

    var _sleep = setInterval(_animateCircle, 25);

    function _animateCircle() {
      //2*pi*r == 753.6 +xxx=764
        _input_percentage = (_upto / 100) * 764;
        _percentage = (_progress / 100) * 764;

        _text_percentage.html(_progress + '%');

        if (_percentage >= _input_percentage) {
             _text_percentage.html('<tspan x="50%" dy="0em">'+unchnagedPer + '% </tspan><tspan  x="50%" dy="1.9em">Your Score</tspan>');
            clearInterval(_sleep);
        } else {

            _progress++;

            _cir_progress.attr("stroke-dasharray",_percentage + ',764');
        }
    }
}

function renderBriefChart(correct, total, incorrect){
  var percent=(100 * correct / total);
  if(Math.round(percent) !== percent) {
          percent = percent.toFixed(2);
  }

 totalPieChart(percent, '_cir_progress', correct, incorrect)
   
}
/*** render chart for result **/
function renderChart(data){
  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
    labels: [ "Verbal communication", 
              "Non-verbal communication", 
              "Written communication", 
              "Incorrect"
            ],
    datasets: [
                {
                 
                  data: data,
                  backgroundColor: [  '#e6ded4',
                                      '#968089',
                                      '#e3c3d4',
                                      '#ab4e6b'
                                    ],
                  borderColor: [  'rgba(239, 239, 81, 1)',
                                  '#8e3407',
                                  'rgba((239, 239, 81, 1)',
                                  '#000000'
                                ],
                  borderWidth: 1
                }
              ]
    },
    options: {
         pieceLabel: {
          render: 'percentage',
          fontColor: 'black',
          precision: 2
        }
      }
    
  });
}

/** List question and your answer and correct answer  

*****/
function getAllAnswer(results){
    var innerhtml="";
    for(var i=0;i<results.length;i++){

      var _class=((results[i].iscorrect)?"item-correct":"item-incorrect");
       var _classH=((results[i].iscorrect)?"h-correct":"h-incorrect");
      

      var _html='<div class="_resultboard '+_class+'">'+
                  '<div class="_header">'+results[i].question+'</div>'+
                  '<div class="_yourans '+_classH+'">'+results[i].clicked+'</div>';

        var html="";
       if(!results[i].iscorrect)
        html='<div class="_correct">'+results[i].answer+'</div>';
       _html=(_html+html)+'</div>';
       innerhtml+=_html;
    }

  $(".allAnswerBox").html('').append(innerhtml);
}
/** render  Brief Result **/
function renderResult(resultList){ 
  
  var results=resultList;
  console.log(results);
  var countCorrect=countAnswers(results)[0], 
  countWrong=countAnswers(results)[1];
  
  
  renderBriefChart(countCorrect, resultList.length, countWrong);
}

function renderChartResult(){
   var results=resultList; 
  var countCorrect=countAnswers(results)[0], 
  countWrong=countAnswers(results)[1];
  var dataForChart=genResultArray(resultList, countWrong);
  renderChart(dataForChart);
}

/** Insert progress bar in html **/
function getProgressindicator(length){
  var progressbarhtml=" ";
  for(var i=0;i<length;i++){
    progressbarhtml+='<div class="my-progress-indicator progress_'+(i+1)+' '+((i==0)?"active":"")+'"></div>';
  }
  $(progressbarhtml).insertAfter(".my-progress-bar");
} 

/*** change progress bar when next button is clicked ***/
function changeProgressValue(){
  $progressValue+= 9;
  if ($progressValue >= 100) {
    
  } else {
    if($progressValue==99) $progressValue=100;
    $('.my-progress')
      .find('.my-progress-indicator.active')
      .next('.my-progress-indicator')
      .addClass('active');      
    $('progress').val($progressValue);
  }
  $('.js-my-progress-completion').html($('progress').val() + '% complete');

}   
function addClickedAnswerToResult(questions,presentIndex,clicked ){
  var correct=getCorrectAnswer(questions, presentIndex);
    var result={
      index:presentIndex,
      question:questions[presentIndex].question, 
      clicked:clicked,
      iscorrect:(clicked==correct)?true:false,
      answer:correct, 
      category:questions[presentIndex].category
    }
    resultList.push(result);

    console.log("result");
    console.log(result);
      
}

$(document).ready(function () { 

  var presentIndex=0;
   var clicked=0;

  var questions=generateQuestions();
  renderQuiz(questions, presentIndex);
  getProgressindicator(questions.length);

  $(".answerOptions ").on('click','.myoptions>input', function(e){
    clicked=$(this).val();   

    if(questions.length==(presentIndex+1)){
      $("#submit").removeClass('hidden');
      $("#next").addClass("hidden");
    }
    else{

      $("#next").removeClass("hidden");
    }

     
  
  });



  $("#next").on('click',function(e){
    e.preventDefault();
    addClickedAnswerToResult(questions,presentIndex,clicked);

    $(this).addClass("hidden");
    
    presentIndex++;
    renderQuiz(questions, presentIndex);
    changeProgressValue();
  });

  $("#submit").on('click',function(e){
     addClickedAnswerToResult(questions,presentIndex,clicked);
    $('.multipleChoiceQues').hide();
    $(".resultArea").show();
    renderResult(resultList);

  });

  
  

   $(".resultArea").on('click','.viewchart',function(){
      $(".resultPage2").show();
       $(".resultPage1").hide();
       $(".resultPage3").hide();
       renderChartResult();
   });

    $(".resultArea").on('click','.backBtn',function(){
      $(".resultPage1").show();
       $(".resultPage2").hide();
       $(".resultPage3").hide();
        renderResult(resultList);
   });

    $(".resultArea").on('click','.viewanswer',function(){
      $(".resultPage3").show();
       $(".resultPage2").hide();
       $(".resultPage1").hide();
        getAllAnswer(resultList);
   });

  $(".resultArea").on('click','.replay',function(){
    window.location.reload(true);
  });

});