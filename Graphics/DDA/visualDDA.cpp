#include <GL/glut.h>
#include <cmath>
#include <iostream>

// This is the DDA function we discussed
void drawLineDDA(float x1, float y1, float x2, float y2)
{
  float dx = x2 - x1;
  float dy = y2 - y1;

  float steps;
  if (abs(dx) > abs(dy))
    steps = abs(dx);
  else
    steps = abs(dy);

  float xIncrement = dx / steps;
  float yIncrement = dy / steps;

  float x = x1;
  float y = y1;

  //! START DRAWING POINTS
  glBegin(GL_POINTS);

  for (int i = 0; i <= steps; i++)
  {
    // This is the OpenGL version of "putpixel"
    glVertex2i(round(x), round(y));

    x += xIncrement;
    y += yIncrement;
  }

  //! STOP DRAWING
  glEnd();
}

// This function tells OpenGL what to show on the screen
void display()
{
  glClear(GL_COLOR_BUFFER_BIT); // Clear the screen
  glColor3f(1.0, 1.0, 1.0);     // Set drawing color to WHITE

  // Call our DDA function to draw a line from (50, 50) to (200, 200)
  drawLineDDA(50, 50, 400, 500);

  glFlush(); // Force the execution of OpenGL commands
}

// This sets up the coordinate system (Graph Paper mode)
void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0); // Set background to BLACK
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();

  // This is crucial: It sets the screen to be a 500x500 grid
  // (0,0) is bottom-left, (500,500) is top-right
  gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  // Set window size and title
  glutInitWindowSize(500, 500);
  glutInitWindowPosition(100, 100);
  glutCreateWindow("My First DDA Line");

  init(); // Call our setup function

  glutDisplayFunc(display); // Tell GLUT to use our 'display' function
  glutMainLoop();           // Keep the window open

  return 0;
}
