#include <iostream>
#include <GL/glut.h>
using namespace std;

float x1_, y1_, x2_, y2_, x3_, y3_;

float p1[3], p2[3], p3[3];
float M[3][3];

void multiply(float point[3], float result[3])
{
  for (int i = 0; i < 3; i++)
  {
    result[i] = 0;
    for (int j = 0; j < 3; j++)
    {
      result[i] += M[i][j] * point[j];
    }
  }
}

void drawTriangle(float a[3], float b[3], float c[3])
{
  glBegin(GL_LINE_LOOP);
  glVertex2f(a[0], a[1]);
  glVertex2f(b[0], b[1]);
  glVertex2f(c[0], c[1]);
  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);
  glColor3f(0, 1, 0);
  glBegin(GL_LINES);
  glVertex2f(-800, 0);
  glVertex2f(800, 0);
  glVertex2f(0, -800);
  glVertex2f(0, 800);
  glEnd();

  // Draw original (Yellow)
  glColor3f(1, 1, 0);
  drawTriangle(p1, p2, p3);

  // Translated points
  float t1[3], t2[3], t3[3];

  multiply(p1, t1);
  multiply(p2, t2);
  multiply(p3, t3);

  // Draw translated (Red)
  glLineWidth(3);
  glColor3f(1, 0, 0);
  drawTriangle(t1, t2, t3);

  glFlush();
}

void init()
{
  glClearColor(0, 0, 0, 1);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(-800, 800, -800, 800);
}

int main(int argc, char **argv)
{
  cout << "Enter Triangle Coordinates:\n";

  cout << "Enter x1 y1: ";
  cin >> x1_ >> y1_;

  cout << "Enter x2 y2: ";
  cin >> x2_ >> y2_;

  cout << "Enter x3 y3: ";
  cin >> x3_ >> y3_;

  // Assign values AFTER input
  p1[0] = x1_;
  p1[1] = y1_;
  p1[2] = 1;

  p2[0] = x2_;
  p2[1] = y2_;
  p2[2] = 1;

  p3[0] = x3_;
  p3[1] = y3_;
  p3[2] = 1;

  int choice;
  cout << "1. Reflect about X-axis\n";
  cout << "2. Reflect about Y-axis\n";
  cout << "3. Reflect about Origin\n";
  cout << "Enter choice: ";
  cin >> choice;

  if (choice == 1)
  {
    M[0][0] = 1;
    M[0][1] = 0;
    M[0][2] = 0;
    M[1][0] = 0;
    M[1][1] = -1;
    M[1][2] = 0;
    M[2][0] = 0;
    M[2][1] = 0;
    M[2][2] = 1;
  }
  else if (choice == 2)
  {
    M[0][0] = -1;
    M[0][1] = 0;
    M[0][2] = 0;
    M[1][0] = 0;
    M[1][1] = 1;
    M[1][2] = 0;
    M[2][0] = 0;
    M[2][1] = 0;
    M[2][2] = 1;
  }
  else if (choice == 3)
  {
    M[0][0] = -1;
    M[0][1] = 0;
    M[0][2] = 0;
    M[1][0] = 0;
    M[1][1] = -1;
    M[1][2] = 0;
    M[2][0] = 0;
    M[2][1] = 0;
    M[2][2] = 1;
  }

  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(800, 800);
  glutCreateWindow("Scaling on Triangle");

  init();
  glutDisplayFunc(display);
  glutMainLoop();
}