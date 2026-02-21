#include <GL/glut.h>
#include <iostream>
#include <cmath>

using namespace std;

float x1, yy1, x2, yy2;
void ddaLine()
{

  float dx = x2 - x1;
  float dy = yy2 - yy1;

  int steps = 0;

  if (abs(dx) > abs(dy))
    steps = abs(dx);
  else
    steps = abs(dy);

  float xInc = dx / steps;
  float yInc = dy / steps;

  float x = x1;
  float y = yy1;

  glBegin(GL_POINTS);

  for (int i = 0; i < steps; i++)
  {
    glVertex2f(round(x), round(y));
    x += xInc;
    y += yInc;
  }

  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);

  ddaLine();

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
  cout << "Enter Value of x1 : ";
  cin >> x1;
  cout << "Enter Value of y1 : ";
  cin >> yy1;
  cout << "Enter Value of x2 : ";
  cin >> x2;
  cout << "Enter Value of y2 : ";
  cin >> yy2;
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(500, 500);
  glutInitWindowPosition(100, 100);
  glutCreateWindow("Graphics Window");
  init();
  glutDisplayFunc(display);
  glutMainLoop();
  return 0;
}