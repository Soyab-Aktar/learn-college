#include <GL/glut.h>
#include <iostream>
using namespace std;

int ww = 600, wh = 600;

// Fill color (Red)
float fillColor[3] = {1.0, 0.0, 0.0};

// Background color (Black)
float bgColor[3] = {0.0, 0.0, 0.0};

// Boundary color (White)
float boundaryColor[3] = {1.0, 1.0, 1.0};

// Function to get pixel color
void getPixel(int x, int y, float color[3])
{
  glReadPixels(x, y, 1, 1, GL_RGB, GL_FLOAT, color);
}

// Function to set pixel color
void setPixel(int x, int y, float color[3])
{
  glColor3fv(color);
  glBegin(GL_POINTS);
  glVertex2i(x, y);
  glEnd();
  glFlush();
}

// Compare two colors
bool sameColor(float color1[3], float color2[3])
{
  return (color1[0] == color2[0] &&
          color1[1] == color2[1] &&
          color1[2] == color2[2]);
}

// Flood Fill Algorithm (4-connected)
void boundaryFill(int mouseX, int mouseY)
{
  float currentColor[3];
  getPixel(mouseX, mouseY, currentColor);

  if (!sameColor(currentColor, boundaryColor) &&
      !sameColor(currentColor, fillColor))
  {
    setPixel(mouseX, mouseY, fillColor);

    boundaryFill(mouseX + 1, mouseY);
    boundaryFill(mouseX - 1, mouseY);
    boundaryFill(mouseX, mouseY + 1);
    boundaryFill(mouseX, mouseY - 1);
  }
}

// Display function
void display()
{
  glClear(GL_COLOR_BUFFER_BIT);

  glColor3f(1.0, 1.0, 1.0); // White boundary
  glBegin(GL_LINE_LOOP);
  glVertex2i(200, 200);
  glVertex2i(400, 200);
  glVertex2i(300, 400);
  glEnd();

  glFlush();
}

// Mouse click event
void mouse(int button, int state, int mouseX, int mouseY)
{
  if (button == GLUT_LEFT_BUTTON && state == GLUT_DOWN)
  {
    // Convert window Y to OpenGL Y
    mouseY = wh - mouseY;
    boundaryFill(mouseX, mouseY);
  }
}

// Initialization
void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0); // Black background

  glMatrixMode(GL_PROJECTION);
  gluOrtho2D(0, ww, 0, wh);
}

// Main function
int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(ww, wh);
  glutCreateWindow("Flood Fill Triangle");

  init();
  glutDisplayFunc(display);
  glutMouseFunc(mouse);

  glutMainLoop();
  return 0;
}