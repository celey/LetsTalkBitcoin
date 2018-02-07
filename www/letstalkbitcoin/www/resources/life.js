var ROWS = 20;
var COLUMNS = 16;
var CELL_SIZE = 40;
var TURN_DURATION = 1000;
var CELL_COLOUR = "#444455";
var GRID_COLOUR = "#777977";
var BOARD_COLOUR = "#FFF7F7"

var CELLS_COUNT = ROWS * COLUMNS;
var LIVE = true;
var DEAD = false;

var GENERATION_TO_CHECK = 32;

var current_board;

var ui_locked = false;
var animation_running = false;
var animation_start_time = 0;
var animation_current_generation = 0;

// Patching and compatibility //////////////////////////////////////////////////

function mod(a, b) {
  return ((a % b) + b) % b;
}

window.requestAnimationFrame = window.requestAnimationFrame
                            || window.mozRequestAnimationFrame
                            || window.webkitRequestAnimationFrame
                            || window.oRequestAnimationFrame
                            || function(callback) {
                                 window.setTimeout(callback, 1000 / 60);
                               };

function findPos(obj) {
    var curleft = 0, curtop = 0;
    if (obj.offsetParent) {
        do {
            curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
        } while ((obj = obj.offsetParent));
        return { x: curleft, y: curtop };
    }
    return undefined;
}

// End patching and compatability //////////////////////////////////////////////

var boardsEqual = function (board_a, board_b) {
  var result = true;
  for (var i = 0; i < CELLS_COUNT; i++) {
    if (board_a[i] != board_b[i]) {
      result = false;
      break;
    }
  }
  return result;
};

var coordsToIndex = function(x, y) {
  return mod(x, COLUMNS) + (mod(y, ROWS) * COLUMNS);
};

var getCell = function(board, x, y) {
  return board[coordsToIndex(x, y)];
};

var setCell = function(board, x, y, state) {
  board[coordsToIndex(x, y)] = state;
};

var flipCell = function(board, x, y) {
  var new_state = ! getCell(board, x, y)
  setCell(board, x, y, new_state);
};

var initBoard = function() {
  var board = Array();
  for (var i = 0; i < CELLS_COUNT; i++) {
    board[i] = DEAD;
  }
  return board;
};

var nextGenerationBoard = function(board) {
  var old_board = board;
  var new_board = Array();
  for (var y = 0; y <= ROWS; y++) {
    for (var x = 0; x <= COLUMNS; x++) {
      setCell(new_board, x, y, nextCellState(old_board, x, y));
    }
  }
  return new_board;
};

var nextCellState = function(board, x, y) {
  var current_state = getCell(board, x, y);
  var adjacent = adjacentCount(board, x, y);
  var next_state = current_state;
  if ((current_state == LIVE) && (adjacent < 2)) {
    next_state = DEAD;
  } else if ((current_state == LIVE) && (adjacent > 3)) {
    next_state = DEAD;
  } else if ((current_state == DEAD) && (adjacent == 3)) {
    next_state = LIVE;
  }
  return next_state;
};

var adjacentCount = function (board, x, y) {
  var count = 0;
  count += getCell(board, x - 1, y - 1);
  count += getCell(board, x,     y - 1);
  count += getCell(board, x + 1, y - 1);
  count += getCell(board, x - 1, y);
  count += getCell(board, x + 1, y);
  count += getCell(board, x - 1, y + 1);
  count += getCell(board, x,     y + 1);
  count += getCell(board, x + 1, y + 1);
  return count;
};

var drawCell = function(ctx, x, y, state) {
  if(state == LIVE) {
    ctx.fillRect(x * CELL_SIZE, y * CELL_SIZE, CELL_SIZE, CELL_SIZE);
  }
};

var drawBoard = function(canvas, board) {
  var ctx = canvas[0].getContext('2d');
  ctx.clearRect(0, 0, canvas[0].width, canvas[0].height);
  drawGrid(ctx);
  drawCells(ctx, board);
};

var drawGrid = function(ctx) {
  ctx.fillStyle = GRID_COLOUR;
  for (var y = 0; y <= ROWS; y++) {
    for (var x = 0; x <= COLUMNS; x++) {
      ctx.beginPath();
      ctx.arc(x * CELL_SIZE, y * CELL_SIZE, 1.0, 0, 2 * Math.PI, false);
      ctx.fill();
    }
  }
};

var drawCells = function(ctx, board) {
  ctx.fillStyle = CELL_COLOUR;
  for(var y = 0; y < ROWS; y++) {
    for(var x = 0; x < COLUMNS; x++) {
      drawCell(ctx, x, y, getCell(board, x, y));
    }
  }
};

var maybeUpdateBoard = function() {
  var updated = false;
  var now = new Date().getTime();
  var generation = Math.floor((now - animation_start_time) / TURN_DURATION);
  if (generation > animation_current_generation) {
    var new_board = nextGenerationBoard(current_board);
    if (boardsEqual(new_board, current_board)) {
      stopAnimating();
      callMeWhenBoardStabilizes();
    } else {
      current_board = new_board
      animation_current_generation = generation;
      updated = true;
    }
  }
  return updated;
};

var animationLoop = function() {
  if (animation_running) {
    var updated = maybeUpdateBoard();
    if(updated) {
      var canvas = $("#life");
      drawBoard(canvas, current_board);
    }
    requestAnimationFrame(animationLoop);
  }
};

var startAnimating = function() {
  if ((! animation_running) && (! ui_locked)) {
    animation_current_generation = 0;
    animation_start_time = new Date().getTime();
    animation_running = true;
    requestAnimationFrame(animationLoop);
  }
};

var stopAnimating = function() {
  animation_running = false;
};

var clearBoard = function() {
  if ((! animation_running) && (! ui_locked)) {
    current_board = initBoard();
    var canvas = $("#life");
    drawBoard(canvas, current_board);
  }
};

var clickBoard = function(event) {
  if((! animation_running) && (! ui_locked)) {
    var canvas = $("#life");
    var pos = findPos(this);
    var x = event.pageX - pos.x;
    var y = event.pageY - pos.y;
    var cell_x = Math.floor(x / CELL_SIZE);
    var cell_y = Math.floor(y / CELL_SIZE);
    flipCell(current_board, cell_x, cell_y);
    drawBoard(canvas, current_board);
  }
};

// This doesn't handle vertical board overlaps
// It could be made to (check for run length) but meh

var getBoardRun = function(board) {
  var start = 0;
  for (var i = 0; i < CELLS_COUNT; i++) {
    if (board[i] == LIVE) {
      start = i;
      break;
    }
  }
  var end = 0;
  for (var j = CELLS_COUNT - 1; j >= 0; j--) {
    if (board[j] == LIVE) {
      end = j;
      break;
    }
  }
  var run = "";
  for (var index = start; index <= end; index++) {
    if(board[index] == LIVE) {
      run += "1";
    } else {
      run += "0";
    }
  }
  return run;
};

var callMeWhenBoardStabilizes = function() {
  ui_locked = true;
  var run = getBoardRun(current_board);
  console.log(run);
  $.post(window.location, {"board": run,
                           "generation": animation_current_generation},
         receiveSubmissionResult, "json");
};

var receiveSubmissionResult = function(data) {
  if(data["error"]) {
    $("#message").html("<b><i>" + data["error"] + "</i></b>");
    ui_locked = false;
  } else {
    if(data["result"] == true) {
      $("#message").html("<b><i>" + "You did it!" + "</i></b>");
    } else {
      $("#message").html("<b><i>" + "Better luck next time..." + "</i></b>");
      ui_locked = false;
    }
  }
};

window.onload = function() {
  var canvas = $("#life");
  canvas.click(clickBoard);
  canvas.css("background", BOARD_COLOUR);
  current_board = initBoard();
  drawBoard(canvas, current_board);
};
