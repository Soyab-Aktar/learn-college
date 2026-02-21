#include <GL/glut.h>

void drawStar()
{
  glBegin(GL_TRIANGLE_FAN);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.0, 0.0);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.0, 0.7);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.2, 0.2);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.7, 0.0);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.2, -0.2);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.0, -0.7);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(-0.2, -0.2);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(-0.7, 0.0);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(-0.2, 0.2);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(0.0, 0.7);

  glEnd();
  //   (0,0.7)
  // (0.2,0.2)
  // (0.7,0)
  // (0.2,-0.2)
  // (0,-0.7)
  // (-0.2,-0.2)
  // (-0.7,0)
  // (-0.2,0.2)
}

void display()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glClear(GL_COLOR_BUFFER_BIT);

  drawStar();

  glFlush();
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);

  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  glutInitWindowSize(500, 500);

  glutCreateWindow("Star Pattern");
  glutDisplayFunc(display);
  glutMainLoop();
}