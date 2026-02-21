#include <iostream>
#include <cmath>
#include <GL/glut.h>
using namespace std;

int radius, xc, yc;

void drawCirclePoints(int x, int y)
{
  glVertex2i(xc + x, yc + y);
  glVertex2i(xc + y, yc + x);
  glVertex2i(xc - x, yc + y);
  glVertex2i(xc - y, yc + x);
  glVertex2i(xc + x, yc - y);
  glVertex2i(xc + y, yc - x);
  glVertex2i(xc - x, yc - y);
  glVertex2i(xc - y, yc - x);
}

void midPoint()
{
  int x = 0;
  int y = radius;
  int p = 1 - radius;

  glBegin(GL_POINTS);

  while (x <= y)
  {
    drawCirclePoints(x, y);
    x += 1;
    if (p < 0)
    {
      p += 2 * x + 1;
    }
    else
    {
      y -= 1;
      p += 2 * x - 2 * y + 1;
    }
  }

  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);

  midPoint();

  glFlush();
}

void init()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char **argv)
{
  cout << "Enter center (xc): ";
  cin >> xc;
  cout << "Enter center (yc): ";
  cin >> yc;

  cout << "Enter radius: ";
  cin >> radius;
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(500, 500);
  glutCreateWindow("Mid-Point Circle Drawing");
  init();
  glutDisplayFunc(display);
  glutMainLoop();
  return 0;
}