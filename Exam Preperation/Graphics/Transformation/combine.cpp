#include <iostream>
#include <cmath>
#include <GL/glut.h>
using namespace std;

float p1[3], p2[3], p3[3];
float Final[3][3]; // Final transformation matrix

// Matrix × Point
void multiplyPoint(float matrix[3][3], float point[3], float result[3])
{
  for (int i = 0; i < 3; i++)
  {
    result[i] = 0;
    for (int j = 0; j < 3; j++)
    {
      result[i] += matrix[i][j] * point[j];
    }
  }
}

// Matrix × Matrix
void multiplyMatrix(float A[3][3], float B[3][3], float result[3][3])
{
  for (int i = 0; i < 3; i++)
  {
    for (int j = 0; j < 3; j++)
    {
      result[i][j] = 0;
      for (int k = 0; k < 3; k++)
      {
        result[i][j] += A[i][k] * B[k][j];
      }
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

  // Draw original triangle (Yellow)
  glColor3f(1, 1, 0);
  drawTriangle(p1, p2, p3);

  // Transformed points
  float t1[3], t2[3], t3[3];

  multiplyPoint(Final, p1, t1);
  multiplyPoint(Final, p2, t2);
  multiplyPoint(Final, p3, t3);

  // Draw transformed triangle (Red)
  glColor3f(1, 0, 0);
  drawTriangle(t1, t2, t3);

  glFlush();
}

void init()
{
  glClearColor(0, 0, 0, 1);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(-800, 800, -800, 800); // allow rotation in all directions
}

int main(int argc, char **argv)
{
  float x1, y1, x2, y2, x3, y3;

  cout << "Enter Triangle Coordinates:\n";

  cout << "Enter x1 y1: ";
  cin >> x1 >> y1;

  cout << "Enter x2 y2: ";
  cin >> x2 >> y2;

  cout << "Enter x3 y3: ";
  cin >> x3 >> y3;

  // Store triangle
  p1[0] = x1;
  p1[1] = y1;
  p1[2] = 1;
  p2[0] = x2;
  p2[1] = y2;
  p2[2] = 1;
  p3[0] = x3;
  p3[1] = y3;
  p3[2] = 1;

  // ---------- Rotation Matrix (45°) ----------
  float R[3][3];
  float rad = 45 * 3.1416 / 180;

  R[0][0] = cos(rad);
  R[0][1] = -sin(rad);
  R[0][2] = 0;
  R[1][0] = sin(rad);
  R[1][1] = cos(rad);
  R[1][2] = 0;
  R[2][0] = 0;
  R[2][1] = 0;
  R[2][2] = 1;

  // ---------- Scaling Matrix (3,3) ----------
  float S[3][3];

  S[0][0] = 3;
  S[0][1] = 0;
  S[0][2] = 0;
  S[1][0] = 0;
  S[1][1] = 3;
  S[1][2] = 0;
  S[2][0] = 0;
  S[2][1] = 0;
  S[2][2] = 1;

  // ---------- Final Matrix = S × R ----------
  multiplyMatrix(S, R, Final);

  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(800, 800);
  glutCreateWindow("Rotate 45 then Scale 3,3");

  init();
  glutDisplayFunc(display);
  glutMainLoop();

  return 0;
}