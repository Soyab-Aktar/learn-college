#include <GL/glut.h>
#include <cmath>
#include <iostream>

using namespace std;

// Global variables (RENAMED to avoid conflict)
float x1_, y1_, x2_, y2_;

void drawDDA()
{
  float dx = x2_ - x1_;
  float dy = y2_ - y1_;

  float steps;
  if (abs(dx) > abs(dy))
    steps = abs(dx);
  else
    steps = abs(dy);

  float xInc = dx / steps;
  float yInc = dy / steps;

  float x = x1_;
  float y = y1_;

  glBegin(GL_POINTS);
  for (int i = 0; i <= steps; i++)
  {
    glVertex2i(round(x), round(y));
    x += xInc;
    y += yInc;
  }
  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);
  glColor3f(1.0, 1.0, 1.0);
  drawDDA();
  glFlush();
}

void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char **argv)
{
  cout << "Enter x1: ";
  cin >> x1_;
  cout << "Enter y1: ";
  cin >> y1_;
  cout << "Enter x2: ";
  cin >> x2_;
  cout << "Enter y2: ";
  cin >> y2_;

  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(500, 500);
  glutCreateWindow("DDA Line Drawing Algorithm");

  init();
  glutDisplayFunc(display);
  glutMainLoop();

  return 0;
}
