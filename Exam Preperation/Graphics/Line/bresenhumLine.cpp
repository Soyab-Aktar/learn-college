#include <iostream>
#include <GL/glut.h>
#include <cmath>
using namespace std;

float x1_, y1_, x2_, y2_;

void lineDraw()
{
  int dx = abs(x2_) - abs(x1_);
  int dy = abs(y2_) - abs(y1_);

  int incType1 = 2 * dy;
  int incType2 = 2 * dy - 2 * dx;

  int p = 2 * dy - dx;

  int x = x1_;
  int y = y1_;

  glBegin(GL_POINTS);
  while (true)
  {
    glVertex2i(x, y);
    if (x == x2_ && y == y2_)
    {
      break;
    }

    if (p < 0)
    {
      x += 1;
      p += incType1;
    }
    if (p >= 0)
    {
      x += 1;
      y += 1;
      p += incType2;
    }
  }

  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);
  lineDraw();
  glFlush();
}

void init()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(0.0, 800.0, 0.0, 800.0);
}

int main(int argc, char **argv)
{
  cout << "Enter Value of x1 : ";
  cin >> x1_;
  cout << "Enter Value of y1 : ";
  cin >> y1_;
  cout << "Enter Value of x2 : ";
  cin >> x2_;
  cout << "Enter Value of y2 : ";
  cin >> y2_;
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(800, 800);
  glutCreateWindow("Bresenhum Algorith");
  init();
  glutDisplayFunc(display);
  glutMainLoop();
}